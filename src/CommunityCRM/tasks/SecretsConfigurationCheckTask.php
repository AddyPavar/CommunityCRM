<?php

namespace CommunityCRM\Tasks;

use CommunityCRM\dto\SystemURLs;
use CommunityCRM\KeyManager;

class SecretsConfigurationCheckTask implements TaskInterface
{
    public function isActive(): bool
    {
        return !KeyManager::getAreAllSecretsDefined();
    }

    public function isAdmin(): bool
    {
        return true;
    }

    public function getLink(): string
    {
        return SystemURLs::getSupportURL('SecretsConfigurationCheckTask');
    }

    public function getTitle(): string
    {
        return gettext('Secret Keys missing from Config.php');
    }

    public function getDesc(): string
    {
        return gettext('Secret Keys missing from Config.php');
    }
}
