<?php

require '../Include/Config.php';
require '../Include/Functions.php';

use CommunityCRM\dto\SystemConfig;
use CommunityCRM\model\CommunityCRM\GroupQuery;
use CommunityCRM\Service\EducationInitiativeService;

$sundaySchoolService = new EducationInitiativeService();
$groups = GroupQuery::create()->filterByActive(true)->filterByIncludeInEmailExport(true)->find();

$colNames = [];
$colNames[] = 'CRM ID';
$colNames[] = 'FirstName';
$colNames[] = 'LastName';
$colNames[] = 'Email';
foreach ($groups as $group) {
    $colNames[] = $group->getName();
}

$sundaySchoolsParents = [];
foreach ($groups as $group) {
    if ($group->isEducationInitiative()) {
        $sundaySchoolParents = [];
        $kids = $sundaySchoolService->getKidsFullDetails($group->getId());
        $parentIds = [];
        foreach ($kids as $kid) {
            if ($kid['dadId'] != '') {
                $parentIds[] = $kid['dadId'];
            }
            if ($kid['momId'] != '') {
                $parentIds[] = $kid['momId'];
            }
        }
        $sundaySchoolsParents[$group->getId()] = $parentIds;
    }
}

header('Content-type: text/csv');
header('Content-Disposition: attachment; filename=EmailExport-' . date(SystemConfig::getValue('sDateFilenameFormat')) . '.csv');
header('Pragma: no-cache');
header('Expires: 0');

$out = fopen('php://output', 'w');
fputcsv($out, $colNames);
foreach ($personService->getPeopleEmailsAndGroups() as $person) {
    $row = [];

    $row[] = $person['id'];
    $row[] = $person['firstName'];
    $row[] = $person['lastName'];
    $row[] = $person['email'];

    foreach ($groups as $group) {
        $groupRole = $person[$group->getName()];
        if ($groupRole == '' && $group->isEducationInitiative()) {
            if (in_array($person['id'], $sundaySchoolsParents[$group->getId()])) {
                $groupRole = 'Parent';
            }
        }
        $row[] = $groupRole;
    }
    fputcsv($out, $row);
}
fclose($out);
