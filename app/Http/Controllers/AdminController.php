<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard');
    }

    public function announcement(Request $request): RedirectResponse
    {
        $config = config('fyzio');
        $config['announcement'] = $request->input('message');
        $config['icon'] = $request->input('icon') ?? 'fa-solid fa-triangle-exclamation';
        $config['color'] = $request->input('color') ?? 'black';
        $config['background'] = $request->input('background') ?? '#f5b648';

        $configFile = fopen(config_path('fyzio.php'), 'w');
        fwrite($configFile, '<?php return ' . var_export($config, true) . ';');
        fclose($configFile);

        return to_route('admin.dashboard');
    }
}
