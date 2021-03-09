<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;
use App\Application\Middleware\TokenMiddleware;
use Doctrine\ORM\EntityManager;
use App\Application\Repository\UserRepository;
use App\Application\Repository\UserPhotoRepository;
use App\Application\Repository\UserMatchRepository;

abstract class UserAction extends Action
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var UserPhotoRepository
     */
    protected $userPhotoRepository;

    /**
     * @var UserMatchRepository
     */
    protected $userMatchRepository;

    /**
     * @param LoggerInterface     $logger
     * @param TokenMiddleware     $tokenMiddleware
     * @param EntityManager       $em
     * @param UserRepository      $userRepository
     * @param UserPhotoRepository $userPhotoRepository
     * @param UserMatchRepository $userMatchRepository
     */
    public function __construct(
        LoggerInterface $logger, 
        TokenMiddleware $tokenMiddleware,
        EntityManager $em, 
        UserRepository $userRepository,
        UserPhotoRepository $userPhotoRepository,
        UserMatchRepository $userMatchRepository
    )
    {
        parent::__construct($logger, $tokenMiddleware);
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->userPhotoRepository = $userPhotoRepository;
        $this->userMatchRepository = $userMatchRepository;
    }
}