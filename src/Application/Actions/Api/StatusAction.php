<?php
declare(strict_types=1);

namespace App\Application\Actions\Api;

use Psr\Http\Message\ResponseInterface as Response;

class StatusAction extends ApiAction
{
	const API_VERSION = '1.0.0';
	
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $response = [
            'status' => 'OK',
            'version' => self::API_VERSION,
            'timestamp' => time(),
        ];

        return $this->respondWithData($response, 200);
    }
}
