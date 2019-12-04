<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\JWTAuth;

class RevokeExistingTokens
{
    protected $jwt;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        DB::table('oauth_access_tokens')
            ->where(['email' => $event->userEmail])->delete();

        DB::table('oauth_access_tokens')->insert([
            ['email' => $event->userEmail, 'token' => $event->tokenId]
        ]);

    }
}
