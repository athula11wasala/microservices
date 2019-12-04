<?php

namespace App\Events;

class AccessTokenCreated
{
    /**
     * The newly created token ID.
     *
     * @var string
     */
    public $tokenId;

    /**
     * The ID of the user associated with the token.
     *
     * @var string
     */
    public $userEmail;

    /**
     * Create a new event instance.
     *
     * @param  string  $tokenId
     * @param  string  $userId
     * @param  string  $clientId
     * @return void
     */
    public function __construct( $userEmail,$token)
    {
        $this->userEmail = $userEmail;
        $this->tokenId = $token;

    }
}
