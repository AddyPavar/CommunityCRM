<?php

namespace CommunityCRM\Authentication;

class AuthenticationResult
{
    public $isAuthenticated;
    public $nextStepURL;
    public $message;
    public $preventRedirect;
}
