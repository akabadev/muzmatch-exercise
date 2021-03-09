<?php
declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Application\Actions\Api\StatusAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Actions\User\ListUserAction;
use App\Application\Actions\User\CreatePhotoUserAction;
use App\Application\Actions\Swipe\CreateSwipeAction;
use App\Application\Actions\Session\LoginAction;

return function (App $app) {

	$app->get('/status', StatusAction::class);

	$app->post('/login', LoginAction::class);

    $app->group('/users', function (Group $group) {
		$group->post('', CreateUserAction::class);       
		$group->get('/profiles', ListUserAction::class);  
		$group->post('/photos', CreatePhotoUserAction::class);       
    });

    $app->group('/swipe', function (Group $group) {
		$group->post('', CreateSwipeAction::class);       
    });
};
