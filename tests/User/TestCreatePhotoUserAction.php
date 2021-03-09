<?php
declare(strict_types=1);

namespace Tests\User;

use Tests\BaseTest;

final class CreateSwipeActionTest extends BaseTest
{
	public function testUserSuccesCreateNewPhoto()
	{
		$endPoint = [
			"endpoint" => "/users/photos",
			"method" => "POST",
			"statusCode" => 201,
			"headers" => [
				"token" => $this->testUser->token
			],
		];
        $params = [
        	"user_id" => $this->testUser->user_id,
            "name" => "New test photo",
            "url" => "url-of-image-1.com"
        ];
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);
        
        $this->endpointSuccess($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testUserFailCreateNewPhotoDueWrongToken()
	{
		$endPoint = [
			"endpoint" => "/users/photos",
			"method" => "POST",
			"statusCode" => 401,
			"headers" => [
				"token" => "Wrong-token!"
			],
		];
        $params = [
        	"user_id" => $this->testUser->user_id,
            "name" => "New test photo",
            "url" => "url-of-the-image-2.com"
        ];
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);
        
        $this->endpointFail($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}
}