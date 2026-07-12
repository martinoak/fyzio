<?php

namespace App\Http\Controllers;

use App\Models\{Announcement, Method, Therapy, Price};
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'methods' => Method::where('type', 'method')->get()->pluck('value')->toArray(),
            'therapies' => Therapy::where('type', 'therapy')->get()->pluck('value')->toArray(),
        ]);
    }

    public function log(): View
    {
        $log = file_get_contents(storage_path('logs/laravel.log'));

        return view('admin.log', compact('log'));
    }

    public function logClear(): RedirectResponse
    {
        $log = file(storage_path('logs/laravel.log'));
        $log = array_slice($log, -350); // ponechat posledních 350 řádků
        file_put_contents(storage_path('logs/laravel.log'), implode('', $log));

        return to_route('admin.log');
    }

    public function announcement(Request $request): RedirectResponse
    {
        $announcement = Announcement::current();

        $announcement->message = $request->input('message');
        $announcement->background = $request->input('background') ?: '#f5b648';
        $announcement->ends_at = $request->filled('end')
            ? Carbon::parse($request->input('end'))
            : null;

        $announcement->save();

        return to_route('admin.dashboard');
    }

    public function saveMethods(Request $request): RedirectResponse
    {
        $methods = $this->cleanValues($request->input('methods', []));
        $therapies = $this->cleanValues($request->input('therapies', []));

        DB::transaction(function () use ($methods, $therapies) {
            // Method and Therapy share the `services` table, distinguished by
            // `type`, so scope the delete to each type instead of truncating.
            Method::where('type', 'method')->delete();
            Therapy::where('type', 'therapy')->delete();

            $methods->each(fn (string $value) => Method::create(['type' => 'method', 'value' => $value]));
            $therapies->each(fn (string $value) => Therapy::create(['type' => 'therapy', 'value' => $value]));
        });

        return back()->with('success', 'Informace aktualizovány.');
    }

    /**
     * Trim, drop empty entries and de-duplicate a list of submitted values.
     */
    private function cleanValues(array $values): \Illuminate\Support\Collection
    {
        return collect($values)
            ->map(fn ($value) => trim((string) $value))
            ->filter()
            ->unique()
            ->values();
    }

    public function pricing(Request $request): View|RedirectResponse
    {
        if ($request->isMethod('post')) {
            // Validate the request
            $request->validate([
                'prices.*.service_name' => 'required|string|max:255',
                'prices.*.duration' => 'nullable|string|max:50',
                'prices.*.price' => 'required|numeric|min:0',
                'prices.*.description' => 'nullable|string',
                'prices.*.icon' => 'required|string|max:100',
            ]);

            // Replace the whole price list atomically: a mid-loop failure rolls
            // the delete back instead of leaving the ceník empty. (truncate()
            // auto-commits in most drivers, so it can't be rolled back — delete
            // can.)
            DB::transaction(function () use ($request) {
                Price::query()->delete();

                foreach ($request->input('prices', []) as $index => $priceData) {
                    if (!empty($priceData['service_name']) && !empty($priceData['price'])) {
                        Price::create([
                            'service_name' => $priceData['service_name'],
                            'duration' => $priceData['duration'] ?? null,
                            'price' => $priceData['price'],
                            'description' => $priceData['description'] ?? null,
                            'icon' => $priceData['icon'],
                            'order' => $index + 1,
                        ]);
                    }
                }
            });

            return back()->with('success', 'Ceník byl úspěšně aktualizován.');
        }

        // GET request - show the pricing form
        $prices = Price::orderBy('order')->get();

        return view('admin.pricing', compact('prices'));
    }
}
