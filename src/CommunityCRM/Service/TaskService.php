<?php

namespace CommunityCRM\Service;

use CommunityCRM\Authentication\AuthenticationManager;
use CommunityCRM\dto\Notification\UiNotification;
use CommunityCRM\Tasks\CheckExecutionTimeTask;
use CommunityCRM\Tasks\CheckUploadSizeTask;
use CommunityCRM\Tasks\CommunityAddress;
use CommunityCRM\Tasks\CommunityNameTask;
use CommunityCRM\Tasks\EmailTask;
use CommunityCRM\Tasks\HttpsTask;
use CommunityCRM\Tasks\IntegrityCheckTask;
use CommunityCRM\Tasks\PersonClassificationDataCheck;
use CommunityCRM\Tasks\PersonGenderDataCheck;
use CommunityCRM\Tasks\PersonRoleDataCheck;
use CommunityCRM\Tasks\PHPPendingDeprecationVersionCheckTask;
use CommunityCRM\Tasks\PHPZipArchiveCheckTask;
use CommunityCRM\Tasks\PrerequisiteCheckTask;
use CommunityCRM\Tasks\PreUpgradeTaskInterface;
use CommunityCRM\Tasks\SecretsConfigurationCheckTask;
use CommunityCRM\Tasks\TaskInterface;
use CommunityCRM\Tasks\UnsupportedDepositCheck;
use CommunityCRM\Tasks\UpdateFamilyCoordinatesTask;

class TaskService
{
    /**
     * @var TaskInterface[]
     */
    private array $taskClasses;
    private array $notificationClasses = [
        //  new LatestReleaseTask()
    ];

    public function __construct()
    {
        $this->taskClasses = [
            new PrerequisiteCheckTask(),
            new CommunityNameTask(),
            new CommunityAddress(),
            new EmailTask(),
            new HttpsTask(),
            new IntegrityCheckTask(),
            new PersonGenderDataCheck(),
            new PersonClassificationDataCheck(),
            new PersonRoleDataCheck(),
            new UpdateFamilyCoordinatesTask(),
            new CheckUploadSizeTask(),
            new CheckExecutionTimeTask(),
            new UnsupportedDepositCheck(),
            new SecretsConfigurationCheckTask(),
            new PHPPendingDeprecationVersionCheckTask(),
            new PHPZipArchiveCheckTask(),
        ];
    }

    public function getCurrentUserTasks(): array
    {
        $tasks = [];
        foreach ($this->taskClasses as $taskClass) {
            if ($taskClass->isActive() && (!$taskClass->isAdmin() || ($taskClass->isAdmin() && AuthenticationManager::getCurrentUser()->isAdmin()))) {
                $tasks[] = [
                    'title' => $taskClass->getTitle(),
                    'link' => $taskClass->getLink(),
                    'admin' => $taskClass->isAdmin(),
                    'desc' => $taskClass->getDesc()
                ];
            }
        }

        return $tasks;
    }

    public function getTaskNotifications(): array
    {
        $tasks = [];
        foreach ($this->notificationClasses as $taskClass) {
            if ($taskClass->isActive()) {
                $tasks[] = new UiNotification($taskClass->getTitle(), 'wrench', $taskClass->getLink(), $taskClass->getDesc(), $taskClass->isAdmin() ? 'warning' : 'info', 12000, 'bottom', 'left');
            }
        }

        return $tasks;
    }

    public function getActivePreUpgradeTasks(): array
    {
        return array_filter($this->taskClasses, fn ($k): bool => $k instanceof PreUpgradeTaskInterface && $k->isActive());
    }
}
