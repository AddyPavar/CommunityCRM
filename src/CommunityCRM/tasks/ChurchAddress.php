<?php

namespace CommunityCRM\Tasks;

use CommunityCRM\Authentication\AuthenticationManager;
use CommunityCRM\dto\SystemConfig;
use CommunityCRM\dto\SystemURLs;

class CommunityAddress implements TaskInterface
{
    public function isActive(): bool
    {
        return AuthenticationManager::getCurrentUser()->isAdmin() && empty(SystemConfig::getValue('sCommunityAddress'));
    }

    public function isAdmin(): bool
    {
        return true;
    }

    public function getLink(): string
    {
        return SystemURLs::getRootPath() . '/SystemSettings.php';
    }

    public function getTitle(): string
    {
        return gettext('Set Community Address');
    }

    public function getDesc(): string
    {
        return gettext('Community Address is not Set.');
    }
}
