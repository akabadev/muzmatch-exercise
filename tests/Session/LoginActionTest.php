<?php
declare(strict_types=1);

namespace Tests\Session;

use Tests\BaseTest;

final class LoginActionTest extends BaseTest
{
	public function testUserSuccesLogin()
	{
		$endPoint = [
			"endpoint" => "/login",
			"method" => "POST",
			"statusCode" => 201,
			"headers" => null,
		];
        $params = [
        	"email" => "damien@gmail.com",
            "password" => "%eYrNMcm22"
        ];
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);
        
        $this->endpointSuccess($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testUserFailLoginDueWrongEmail()
	{
		$endPoint = [
			"endpoint" => "/login",
			"method" => "POST",
			"statusCode" => 401,
			"headers" => null,
		];
        $params = [
        	"email" => "damien@gmail.com",
            "password" => "%eYrNMcm22"
        ];
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);
        
        $this->endpointFail($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

	public function testUserFailLoginDueWrongPassword()
	{
		$endPoint = [
			"endpoint" => "/login",
			"method" => "POST",
			"statusCode" => 401,
			"headers" => null,
		];
        $params = [
        	"email" => "damien@gmail.com",
            "password" => "this is not ur password"
        ];
        $endPoint["endpoint"] = $endPoint["endpoint"]."?".http_build_query($params);
        
        $this->endpointFail($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}
}
