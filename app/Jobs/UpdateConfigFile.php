<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateConfigFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $configData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $configData)
    {
        $this->configData = $configData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $config = config('fyzio');
        // Assume $this->configData is passed through the job's constructor
        $config['announcement'] = $this->configData['message'];
        $config['background'] = $this->configData['background'] ?? '#f5b648';

        $configFile = fopen(config_path('fyzio.php'), 'w');
        fwrite($configFile, '<?php return ' . var_export($config, true) . ';');
        fclose($configFile);
    }
}
