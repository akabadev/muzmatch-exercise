<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class BaseTest extends TestCase
{
	const BASE_URI = "http://localhost:8080";

	/**
     * @var object
	 */
	protected $testUser; 

	protected function setUp(): void
	{
		$this->client = new Client([
			'base_uri' => self::BASE_URI
		]);
		
		$this->testUser = $this->createTestToken();
	}

	private function createTestToken()
	{
		$endPoint = [
			"endpoint" => "/login",
			"method" => "POST",
			"statusCode" => 201,
			"headers" => null,
		];
        $params = [
        	"email" => "mynuella@britishairways.com",
            "password" => "%AT>\~@n7z5._n&c"
        ];
        $path = $endPoint["endpoint"]."?".http_build_query($params);
        $response = $this->client->{strtolower($endPoint["method"])}($path, [
            'headers' => $endPoint["headers"],
        ]);


        $loginResponse = json_decode($response->getBody()->getContents());

		return $loginResponse->data;
	}

	public function testStatusApi()
	{
		$endPoint = [
			"endpoint" => "/status",
			"method" => "GET",
			"statusCode" => 200,
			"headers" => null,
		];

		$this->endpointSuccess($endPoint["endpoint"], $endPoint["method"], $endPoint["statusCode"], $endPoint["headers"]);
	}

    protected function endpointSuccess(
    	string $path, 
    	string $method, 
    	int $statusCode, 
    	array $headers = null)
    {
        $response = $this->client->{strtolower($method)}($path, [
            'headers' => $headers,
        ]);

        $this->assertEquals($statusCode, $response->getStatusCode());
    }

    protected function endpointFail(
    	string $path, 
    	string $method, 
    	int $statusCode, 
    	array $headers = null
    )
    {
        try {
            $this->client->{strtolower($method)}($path, [
                'headers' => $headers,
            ]);
        } catch (ClientException $e) {
            $this->assertEquals($statusCode, $e->getCode());
        }
    }
}