<?php

/*
 * Garage -- A code kata for the automobile owner
 *
 * Copyright (C) <2019> <Kyle Klaus>
 *
 * This software may be modified and distributed under the terms of the MIT license.  See the LICENSE file for details.
 */

namespace App\Console\Commands;

use Zttp\Zttp;
use Illuminate\Support\Arr;
use Illuminate\Console\Command;

class RollbarReportCommand extends Command
{
    /**
     * The rollbar API endpoint.
     */
    const ROLLBAR_API = 'https://api.rollbar.com/api/1';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollbar:report 
                            {revision : Git SHA of revision being deployed}
                            {--u|username= : Rollbar username of person who deployed}
                            {--l|localuser= : Local username of person who deployed. Displayed in web app if no rollbar_username was specified}
                            {--c|comment= : Additional text to include with the deploy}
                            {--s|status=succeeded : Status of the deployment - started, succeeded, failed, or timed_out}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report a deploy of the application.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $response = Zttp::post(self::ROLLBAR_API.'/deploy', [
            'access_token' => config('logging.channels.rollbar.access_token'),
            'environment' => config('app.env'),
            'revision' => $this->argument('revision'),
            'rollbar_username' => $this->option('username'),
            'local_username' => $this->option('localuser'),
            'comment' => $this->option('comment'),
            'status' => $this->option('status'),
        ]);

        if (! $response->isOk()) {
            $this->error(Arr::get($response->json(), 'message'));
            exit(Arr::get($response->json(), 'err') || $response->status());
        }

        $deployId = Arr::get($response->json(), 'data.deploy_id');
        $this->info("Revision [{$this->argument('revision')}] has been reported: https://rollbar.com/deploy/{$deployId}");
    }
}
