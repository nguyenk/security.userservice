<?php
/*
 * Copyright (c) 2012 David Negrier
 *
 * See the file LICENSE.txt for copying permission.
 */

require_once __DIR__."/../../../autoload.php";

use Mouf\Actions\InstallUtils;
use Mouf\MoufManager;

// Let's init Mouf
InstallUtils::init(InstallUtils::$INIT_APP);

// Let's create the instance
$moufManager = MoufManager::getMoufManager();
if (!$moufManager->instanceExists("userService")) {
	$userService = $moufManager->createInstance("Mouf\\Security\\UserService\\UserService");
	$userService->setName("userService");
	if ($moufManager->instanceExists("errorLogLogger")) {
		$userService->getProperty("log")->setValue($moufManager->getInstanceDescriptor("errorLogLogger"));
	}
	if ($moufManager->instanceExists("sessionManager")) {
		$userService->getProperty("sessionManager")->setValue($moufManager->getInstanceDescriptor("sessionManager"));
	}
	$userService->getProperty('sessionPrefix')->setValue('ROOT_URL')->setOrigin('config');
}

// Let's rewrite the MoufComponents.php file to save the component
$moufManager->rewriteMouf();

// Finally, let's continue the install
InstallUtils::continueInstall();
?>