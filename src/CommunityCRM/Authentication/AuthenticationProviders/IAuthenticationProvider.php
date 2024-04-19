<?php

namespace CommunityCRM\Authentication\AuthenticationProviders;

use CommunityCRM\Authentication\AuthenticationResult;
use CommunityCRM\Authentication\Requests\AuthenticationRequest;
use CommunityCRM\model\CommunityCRM\User;

interface IAuthenticationProvider
{
    public function authenticate(AuthenticationRequest $AuthenticationRequest): AuthenticationResult;

    public function validateUserSessionIsActive(bool $updateLastOperationTimestamp): AuthenticationResult;

    public function getCurrentUser(): ?User;

    public function endSession(): void;

    public function getPasswordChangeURL(): string;
}
