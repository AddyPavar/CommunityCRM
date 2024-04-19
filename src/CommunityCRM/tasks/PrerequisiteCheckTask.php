<?php

namespace CommunityCRM\Tasks;

use CommunityCRM\dto\SystemURLs;
use CommunityCRM\Service\AppIntegrityService;

class PrerequisiteCheckTask implements TaskInterface
{
    public function isActive(): bool
    {
        return !AppIntegrityService::arePrerequisitesMet();
    }

    public function isAdmin(): bool
    {
        return true;
    }

    public function getLink(): string
    {
        return SystemURLs::getRootPath() . '/v2/admin/debug';
    }

    public function getTitle(): string
    {
        return gettext('Unmet Application Prerequisites');
    }

    public function getDesc(): string
    {
        return gettext('Unmet Application Prerequisites');
    }
}
