<?php
declare(strict_types=1);

namespace Tests\User;

use Tests\BaseTest;

final class ListUserActionTest extends BaseTest
{
	public function testUserSuccesListUser()
	{
		$endPoint = [
			"endpoint" => "/users/profiles",
			"method" => "GET",
			"statusCode" => 200,
            "headers" => [
                "token" => $this->testUser->token
            ],
		];
        $params = [
            "user_id" => $this->testUser->user_id,
        ];
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);
        
        $this->endpointSuccess($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testUserFailListUserDueWrongToken()
	{
        $endPoint = [
            "endpoint" => "/users/profiles",
            "method" => "GET",
            "statusCode" => 401,
            "headers" => [
                "token" => "Wrong-token"
            ],
        ];
        $params = [
            "user_id" => $this->testUser->user_id,
        ];

        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);
        
        $this->endpointFail($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}
}