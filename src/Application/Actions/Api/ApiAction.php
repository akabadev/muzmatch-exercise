<?php
declare(strict_types=1);

namespace App\Application\Actions\Api;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;
use App\Application\Middleware\TokenMiddleware;

abstract class ApiAction extends Action
{
    /**
     * @param LoggerInterface $logger
     * @param TokenMiddleware $tokenMiddleware
     */
    public function __construct(LoggerInterface $logger, TokenMiddleware $tokenMiddleware)
    {
        parent::__construct($logger, $tokenMiddleware);
    }
}
