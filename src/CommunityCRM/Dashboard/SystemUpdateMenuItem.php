<?php

namespace CommunityCRM\Dashboard;

use CommunityCRM\Utils\CommunityCRMReleaseManager;
use CommunityCRM\Utils\LoggerUtils;

class SystemUpdateMenuItem implements DashboardItemInterface
{
    public static function getDashboardItemName(): string
    {
        return 'SystemUpgrade';
    }

    public static function shouldInclude(string $PageName): bool
    {
        return true;
    }

    public static function getDashboardItemValue(): array
    {
        $data['newVersion'] = '';
        $installedVersion = CommunityCRMReleaseManager::getReleaseFromString($_SESSION['sSoftwareInstalledVersion']);
        $isCurrent = CommunityCRMReleaseManager::isReleaseCurrent($installedVersion);
        if (!$isCurrent) {
            try {
                // This can fail with an exception if the currently running software is "not current"
                // but there are no more available releases.
                // this exception will really only happen when running development versions of the software
                // or if the CommunityCRM Release on which the current instance is running has been deleted
                $data['newVersion'] = CommunityCRMReleaseManager::getNextReleaseStep($installedVersion);
            } catch (\Exception $e) {
                LoggerUtils::getAppLogger()->debug($e);
            }
        }

        return $data;
    }
}
