<?php
require_once('../../../Change/Application.php');
require_once('ConfigResolver.php');

$application = new \Change\Application();
$application->start();

$controller = new \Change\Http\Rest\Controller($application);
$actionResolver = new \Change\Http\Rest\Resolver();
$actionResolver->addResolverClasses('config', 'ConfigResolver');
$controller->setActionResolver($actionResolver);
$request = new \Change\Http\Rest\Request();

$allow = $application->inDevelopmentMode();
$anonymous = function (\Change\Http\Event $event) use ($allow)
{
	$event->getPermissionsManager()->allow($allow);
};

$controller->getEventManager()->attach(\Change\Http\Event::EVENT_REQUEST, $anonymous, 100);
$response = $controller->handle($request);
$response->send();