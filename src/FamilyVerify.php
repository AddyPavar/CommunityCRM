<?php

require 'Include/Config.php';
require 'Include/Functions.php';

use CommunityCRM\model\CommunityCRM\FamilyQuery;
use CommunityCRM\Utils\InputUtils;

//Get the FamilyID out of the querystring
$iFamilyID = InputUtils::legacyFilterInput($_GET['FamilyID'], 'int');

$family = FamilyQuery::create()
    ->findOneById($iFamilyID);

$family->verify();

header('Location: ' . $family->getViewURI());
exit;
