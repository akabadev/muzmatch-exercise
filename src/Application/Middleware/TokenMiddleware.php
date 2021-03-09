<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use Doctrine\ORM\EntityManager;
use App\Domain\UserSession;

final class TokenMiddleware
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Validate user account token
     * 
     * @param Request $request
     *
     * @return bool
     */
    public function checkToken(Request $request): bool
    {
        $token = $request->getHeaders()["token"][0];
        $userId = (int)$request->getQueryParams()["user_id"];
        $tokenResult = $this->em
            ->getRepository(UserSession::class)
            ->findOneBy(['userAccountId' => $userId, 'token' => $token]);
        if ( !$tokenResult ) {
            return false;
        }
        if ( $tokenResult->getExpired() < new \DateTime() ) {
            return false;
        } 

        return true;
    }
}
