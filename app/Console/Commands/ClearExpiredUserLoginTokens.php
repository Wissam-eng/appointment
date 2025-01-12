<?php

namespace App\Console\Commands;
use app\UserLoginToken;
use Illuminate\Console\Command;

class ClearExpiredUserLoginTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-expired-user-login-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'flaush expired user login tokens';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        UserLoginToken::expired()->delete();
    }
}
