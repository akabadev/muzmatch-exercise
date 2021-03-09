<?php
declare(strict_types=1);

namespace App\Application\Actions\Swipe;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use App\Application\Middleware\TokenMiddleware;

abstract class SwipeAction extends Action
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param LoggerInterface  $logger
     * @param TokenMiddleware  $tokenMiddleware
     * @param EntityManager    $em
     */
    public function __construct(
        LoggerInterface $logger, 
        TokenMiddleware $tokenMiddleware,
        EntityManager $em 
    )
    {
        parent::__construct($logger, $tokenMiddleware);
        $this->em = $em;
    }
}