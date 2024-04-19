<?php

use CommunityCRM\Authentication\AuthenticationManager;
use CommunityCRM\dto\SystemConfig;
use CommunityCRM\dto\SystemURLs;
use CommunityCRM\model\CommunityCRM\CalendarQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Slim\Views\PhpRenderer;

$app->group('/calendar', function (RouteCollectorProxy $group): void {
    $group->get('/', 'getCalendar');
    $group->get('', 'getCalendar');
});

function getCalendar(Request $request, Response $response, array $args): Response
{
    $renderer = new PhpRenderer('templates/calendar/');

    $pageArgs = [
        'sRootPath'      => SystemURLs::getRootPath(),
        'sPageTitle'     => gettext('Calendar'),
        'calendarJSArgs' => getCalendarJSArgs(),
    ];

    return $renderer->render($response, 'calendar.php', $pageArgs);
}

function getCalendarJSArgs()
{
    return [
        'isModifiable'               => AuthenticationManager::getCurrentUser()->isAddEvent(),
        'countCalendarAccessTokens'  => CalendarQuery::create()->filterByAccessToken(null, Criteria::NOT_EQUAL)->count(),
        'bEnableExternalCalendarAPI' => SystemConfig::getBooleanValue('bEnableExternalCalendarAPI'),
    ];
}
