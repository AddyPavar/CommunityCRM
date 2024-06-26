<?php

use CommunityCRM\model\CommunityCRM\PredefinedReportsQuery;
use CommunityCRM\model\CommunityCRM\QueryParameterOptionsQuery;
use CommunityCRM\model\CommunityCRM\QueryParametersQuery;
use CommunityCRM\model\CommunityCRM\UserConfigQuery;
use CommunityCRM\Slim\Middleware\Request\Auth\AdminRoleAuthMiddleware;
use CommunityCRM\Slim\Request\SlimUtils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

$app->group('/locale', function (RouteCollectorProxy $group): void {
    $group->get('/database/terms', 'getDBTerms');
})->add(AdminRoleAuthMiddleware::class);

function getDBTerms(Request $request, Response $response, array $args): Response
{
    $terms = [];

    $dbTerms = UserConfigQuery::create()->select(['ucfg_tooltip'])->distinct()->find();
    foreach ($dbTerms as $term) {
        $terms[] = $term;
    }

    $dbTerms = QueryParameterOptionsQuery::create()->select(['qpo_Display'])->distinct()->find();
    foreach ($dbTerms as $term) {
        $terms[] = $term;
    }

    $dbTerms = PredefinedReportsQuery::create()->select(['qry_Name', 'qry_Description'])->distinct()->find();
    foreach ($dbTerms as $term) {
        $terms[] = $term['qry_Name'];
        $terms[] = $term['qry_Description'];
    }

    $dbTerms = QueryParametersQuery::create()->select(['qrp_Name', 'qrp_Description'])->distinct()->find();
    foreach ($dbTerms as $term) {
        $terms[] = $term['qrp_Name'];
        $terms[] = $term['qrp_Description'];
    }

    return SlimUtils::renderJSON($response, ['terms' => $terms]);
}
