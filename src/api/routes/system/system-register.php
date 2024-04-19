<?php

use CommunityCRM\dto\SystemConfig;
use CommunityCRM\Service\SystemService;
use CommunityCRM\Slim\Middleware\Request\Auth\AdminRoleAuthMiddleware;
use CommunityCRM\Slim\Request\SlimUtils;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

$app->group('/register', function (RouteCollectorProxy $group): void {
    $group->post('', function (Request $request, Response $response, array $args): Response {
        $input = $request->getParsedBody();

        $registrationData = new \stdClass();
        $registrationData->sName = SystemConfig::getValue('sCommunityName');
        $registrationData->sAddress = SystemConfig::getValue('sCommunityAddress');
        $registrationData->sCity = SystemConfig::getValue('sCommunityCity');
        $registrationData->sState = SystemConfig::getValue('sCommunityState');
        $registrationData->sZip = SystemConfig::getValue('sCommunityZip');
        $registrationData->sCountry = SystemConfig::getValue('sCommunityCountry');
        $registrationData->sEmail = SystemConfig::getValue('sCommunityEmail');
        $registrationData->CommunityCRMURL = $input['CommunityCRMURL'];
        $registrationData->Version = SystemService::getInstalledVersion();

        $registrationData->sComments = $input['emailmessage'];
        $curlService = curl_init('https://demo.communitycrm.io/register.php');

        curl_setopt($curlService, CURLOPT_POST, true);
        curl_setopt($curlService, CURLOPT_POSTFIELDS, json_encode($registrationData, JSON_THROW_ON_ERROR));
        curl_setopt($curlService, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlService, CURLOPT_CONNECTTIMEOUT, 1);

        $result = curl_exec($curlService);
        if ($result === false) {
            throw new \Exception('Unable to reach the registration server', 500);
        }

        // =Turn off the registration flag so the menu option is less obtrusive
        SystemConfig::setValue('bRegistered', '1');

        return SlimUtils::renderSuccessJSON($response);
    });
})->add(AdminRoleAuthMiddleware::class);
