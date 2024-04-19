<?php

namespace CommunityCRM\Tasks;

use CommunityCRM\Authentication\AuthenticationManager;
use CommunityCRM\dto\SystemConfig;
use CommunityCRM\dto\SystemURLs;

class CommunityNameTask implements TaskInterface
{
    public function isActive(): bool
    {
        return AuthenticationManager::getCurrentUser()->isAdmin() && SystemConfig::getValue('sCommunityName') == 'Some Community';
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
        return gettext('Update Community Info');
    }

    public function getDesc(): string
    {
        return gettext('Community Name is set to default value');
    }
}
