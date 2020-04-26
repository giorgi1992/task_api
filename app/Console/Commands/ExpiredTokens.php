<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User_tokens;

class ExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:expired-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove expired tokens';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $response = User_tokens::where('expires_at', '<', now())->delete();
        if($response) {
            print "Expired token(s) has been deleted\n";
        } else {
            print "Expired token does not exist\n";
        }
    }
}
