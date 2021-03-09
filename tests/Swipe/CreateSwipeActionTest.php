<?php
declare(strict_types=1);

namespace Tests\Swipe;

use Tests\BaseTest;

final class CreateSwipeActionTest extends BaseTest
{
	public function testUserSuccesSwipe()
	{
		$endPoint = [
			"endpoint" => "/swipe",
			"method" => "POST",
			"statusCode" => 201,
			"headers" => [
				"token" => $this->testUser->token
			],
		];
        $params = [
        	"user_id" => $this->testUser->user_id,
            "referral_id" => "9",
            "swipe" => "1"
        ];
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);
        
        $this->endpointSuccess($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testUserFailSwipeDueWrongToken()
	{
		$endPoint = [
			"endpoint" => "/swipe",
			"method" => "POST",
			"statusCode" => 401,
			"headers" => [
				"token" => "Wrong-token!"
			],
		];
        $params = [
        	"user_id" => $this->testUser->user_id,
            "referral_id" => "9",
            "swipe" => "1"
        ];
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);
        
        $this->endpointFail($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}
}