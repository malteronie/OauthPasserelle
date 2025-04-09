<?php

namespace App\Console\Commands;

use App\Models\AccessToken;
use Illuminate\Console\Command;
class DeleteToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:delete-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = AccessToken::where('user_id', '>=', '2')
        ->count();
        \Log::info("Nombre de tokens supprimés : " . $count);


        AccessToken::where('expires_at', '<=', now())
    ->delete();
dd('ok');
}
}
