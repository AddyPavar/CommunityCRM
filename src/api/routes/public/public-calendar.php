<?php

use CommunityCRM\dto\CommunityMetaData;
use CommunityCRM\dto\iCal;
use CommunityCRM\Slim\Middleware\Request\PublicCalendarAPIMiddleware;
use CommunityCRM\Slim\Request\SlimUtils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

$app->group('/public/calendar', function (RouteCollectorProxy $group): void {
    $group->get('/{CalendarAccessToken}/events', 'getJSON');
    $group->get('/{CalendarAccessToken}/ics', 'getICal');
    $group->get('/{CalendarAccessToken}/fullcalendar', 'getPublicCalendarFullCalendarEvents');
})->add(PublicCalendarAPIMiddleware::class);

function getJSON(Request $request, Response $response): Response
{
    $events = $request->getAttribute('events');

    return SlimUtils::renderJSON($response, $events->toArray());
}

function getICal($request, $response)
{
    $calendar = $request->getAttribute('calendar');
    $events = $request->getAttribute('events');
    $calendarName = $calendar->getName() . ': ' . CommunityMetaData::getCommunityName();
    $CalendarICS = new iCal($events, $calendarName);
    $body = $response->getBody();
    $body->write($CalendarICS->toString());

    return $response->withHeader('Content-type', 'text/calendar; charset=utf-8')
        ->withHeader('Content-Disposition', 'attachment; filename=calendar.ics');
}

function getPublicCalendarFullCalendarEvents($request, Response $response): Response
{
    $calendar = $request->getAttribute('calendar');
    $events = $request->getAttribute('events');

    return SlimUtils::renderJSON($response, EventsObjectCollectionToFullCalendar($events, $calendar));
}
