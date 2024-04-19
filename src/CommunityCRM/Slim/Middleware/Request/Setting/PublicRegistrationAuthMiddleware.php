<?php

namespace CommunityCRM\Slim\Middleware\Request\Setting;

class PublicRegistrationAuthMiddleware extends BaseAuthSettingMiddleware
{
    protected function getSettingName(): string
    {
        return 'bEnableSelfRegistration';
    }
}
