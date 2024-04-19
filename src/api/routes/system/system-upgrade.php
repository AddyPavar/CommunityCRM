<?php

use CommunityCRM\Slim\Middleware\Request\Auth\AdminRoleAuthMiddleware;
use CommunityCRM\Slim\Request\SlimUtils;
use CommunityCRM\Utils\CommunityCRMReleaseManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

$app->group('/systemupgrade', function (RouteCollectorProxy $group): void {
    $group->get('/downloadlatestrelease', function (Request $request, Response $response, array $args): Response {
        $upgradeFile = CommunityCRMReleaseManager::downloadLatestRelease();

        return SlimUtils::renderJSON($response, $upgradeFile);
    });

    $group->post('/doupgrade', function (Request $request, Response $response, array $args): Response {
        $input = $request->getParsedBody();
        CommunityCRMReleaseManager::doUpgrade($input['fullPath'], $input['sha1']);

        return SlimUtils::renderSuccessJSON($response);
    });
})->add(AdminRoleAuthMiddleware::class);
