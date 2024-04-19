<?php

use CommunityCRM\Authentication\AuthenticationManager;
use CommunityCRM\dto\CommunityMetaData;
use CommunityCRM\dto\SystemConfig;
use CommunityCRM\dto\SystemURLs;
use CommunityCRM\model\CommunityCRM\EventAttendQuery;
use CommunityCRM\model\CommunityCRM\FamilyQuery;
use CommunityCRM\model\CommunityCRM\GroupQuery;
use CommunityCRM\model\CommunityCRM\PersonQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

$app->get('/dashboard', 'viewDashboard');

function viewDashboard(Request $request, Response $response, array $args): Response
{
    $renderer = new PhpRenderer('templates/root/');

    $dashboardCounts = [];

    $dashboardCounts['families'] = FamilyQuery::Create()
        ->filterByDateDeactivated()
        ->count();

    $dashboardCounts['People'] = PersonQuery::create()
        ->leftJoinWithFamily()
        ->where('Family.DateDeactivated is null')
        ->count();

    $dashboardCounts['EducationInitiative'] = GroupQuery::create()
        ->filterByType(4)
        ->count();

    $dashboardCounts['Groups'] = GroupQuery::create()
        ->filterByType(4, Criteria::NOT_EQUAL)
        ->count();

    $dashboardCounts['events'] = EventAttendQuery::create()
        ->filterByCheckinDate(null, Criteria::NOT_EQUAL)
        ->filterByCheckoutDate(null, Criteria::EQUAL)
        ->find()
        ->count();

    $pageArgs = [
        'sRootPath'           => SystemURLs::getRootPath(),
        'sPageTitle'          => gettext('Welcome to') . ' ' . CommunityMetaData::getCommunityName(),
        'dashboardCounts'     => $dashboardCounts,
        'sundaySchoolEnabled' => SystemConfig::getBooleanValue('bEnabledEducationInitiative'),
        'depositEnabled'      => AuthenticationManager::getCurrentUser()->isFinanceEnabled(),
    ];

    return $renderer->render($response, 'dashboard.php', $pageArgs);
}
