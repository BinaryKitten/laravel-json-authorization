<?php

namespace Voice\JsonAuthorization\Authorization;

use Illuminate\Support\Facades\Auth;
use Voice\JsonAuthorization\App\Contracts\AuthorizesUsers;
use Voice\JsonAuthorization\Exceptions\AuthorizationException;

class AuthenticatedUser
{
    public ?AuthorizesUsers $user = null;

    /**
     * AuthenticatedUser constructor.
     * @throws AuthorizationException
     */
    public function __construct()
    {
        if (!Auth::check()) {
            // Don't throw an exception, it will wreak havoc.
            // Also, it is completely valid not to be authenticated...
            return;
        }

        $this->user = Auth::user();

        if (!$this->user instanceof AuthorizesUsers) {
            throw new AuthorizationException("User model must implement AuthorizesUsers interface.");
        }
    }

    public function isLoggedIn(): bool
    {
        return $this->user !== null;
    }
}
