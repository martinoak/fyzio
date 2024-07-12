<?php

namespace App\Http\Controllers;

use App\Models\{Customer, Method, Therapy};
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    protected const PAGINATE = 5;

    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'customers' => Customer::where('term', null)->paginate(self::PAGINATE),
            'archivedCustomers' => Customer::where('term', '>=', date('Y-m-d'))->limit(3)->get(),
            'methods' => Method::where('type', 'method')->get()->pluck('value')->toArray(),
            'therapies' => Therapy::where('type', 'therapy')->get()->pluck('value')->toArray(),
            ]);
    }

    public function announcement(Request $request): RedirectResponse
    {
        $config = config('fyzio');
        $config['announcement'] = $request->input('message');
        $config['background'] = $request->input('background') ?? '#f5b648';

        $configFile = fopen(config_path('fyzio.php'), 'w');
        fwrite($configFile, '<?php return ' . var_export($config, true) . ';');
        fclose($configFile);

        return to_route('admin.dashboard');
    }

    public function customer(string $action, string $id): RedirectResponse
    {
        if ($action === 'delete') {
            DB::table('customers')->where('id', $id)->delete();
        }

        return to_route('admin.dashboard');
    }

    public function saveMethods(Request $request): RedirectResponse
    {
        Method::truncate();
        Therapy::truncate();

        foreach ($request->input('methods') as $method) {
            if (empty($method) || Method::where('value', $method)->exists()) {
                continue;
            } else {
                Method::create([
                    'type' => 'method',
                    'value' => $method,
                ]);
            }
        }

        foreach ($request->input('therapies') as $therapy) {
            if (empty($therapy) || Therapy::where('value', $therapy)->exists()) {
                continue;
            } else {
                Therapy::create([
                    'type' => 'therapy',
                    'value' => $therapy,
                ]);
            }
        }

        return back()->with('success', 'Informace aktualizovány.');
    }
}
