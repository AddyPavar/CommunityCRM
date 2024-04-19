<?php

use CommunityCRM\Service\FinancialService;
use CommunityCRM\Service\GroupService;
use CommunityCRM\Service\PersonService;
use CommunityCRM\Service\SystemService;
use Symfony\Component\DependencyInjection\ContainerInterface;

// DIC configuration
/** @var ContainerInterface $container */

$container->set('PersonService', new PersonService());

$container->set('GroupService', new GroupService());

$container->set('FinancialService', new FinancialService());

$container->set('SystemService', new SystemService());
