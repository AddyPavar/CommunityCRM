<?php

use CommunityCRM\Service\NewDashboardService;
use CommunityCRM\Service\SystemService;
use CommunityCRM\Slim\Request\SlimUtils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

$app->group('/background', function (RouteCollectorProxy $group): void {
    $group->get('/page', 'getPageCommonData');
    $group->post('/timerjobs', 'runTimerJobsAPI');
});

function getPageCommonData(Request $request, Response $response, array $args): Response
{
    $pageName = $request->getQueryParams()['name'];
    $DashboardValues = NewDashboardService::getValues($pageName);
    return SlimUtils::renderJSON($response, $DashboardValues);
}

function runTimerJobsAPI(Request $request, Response $response, array $args): Response
{
    SystemService::runTimerJobs();
    return $response;
}
