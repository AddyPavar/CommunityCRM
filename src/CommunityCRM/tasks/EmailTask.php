<?php

namespace CommunityCRM\Tasks;

use CommunityCRM\Authentication\AuthenticationManager;
use CommunityCRM\dto\SystemConfig;
use CommunityCRM\dto\SystemURLs;

class EmailTask implements TaskInterface
{
    public function isActive(): bool
    {
        return AuthenticationManager::getCurrentUser()->isAdmin() && empty(SystemConfig::hasValidMailServerSettings());
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
        return gettext('Set Email Settings');
    }

    public function getDesc(): string
    {
        return gettext('SMTP Server info are blank');
    }
}
