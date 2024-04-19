<?php

namespace CommunityCRM\Authentication\Requests;

class LocalTwoFactorTokenRequest extends AuthenticationRequest
{
    public $TwoFACode;

    public function __construct($TwoFACode)
    {
        $this->TwoFACode = $TwoFACode;
    }
}
