<?php

namespace CommunityCRM\Authentication\Requests;

class APITokenAuthenticationRequest extends AuthenticationRequest
{
    public function __construct($APIToken)
    {
        $this->APIToken = $APIToken;
    }
    public $APIToken;
}
