<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $all = DB::table('customers')->get()->toArray();
        $customers = array_filter($all, fn($customer) => !$customer->is_archived);
        $archivedCustomers = array_filter($all, fn($customer) => $customer->is_archived);

        return view('admin.dashboard', compact(['customers', 'archivedCustomers']));
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
}
