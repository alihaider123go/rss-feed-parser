<?php

namespace App\Console\Commands;
use Facades\Services\ZapTapService;
use Illuminate\Console\Command;

class ZapTapTriggerAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trigger:alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger ZapTap alerts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ZapTapService::triggerZapTapAlertActions();
    }
}
