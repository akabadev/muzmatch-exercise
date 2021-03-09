<?php
declare(strict_types=1);

namespace App\Application\Actions\Session;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Domain\User;
use App\Domain\UserSession;

final class LoginAction extends SessionAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
    	$requestParams = $this->request->getQueryParams();
    	$userData = $this->em
            ->getRepository(User::class)
            ->findOneBy(['email' => $requestParams['email']]);
        # Validate if email and password is correct
        if (!$userData) {
        	return $this->respondWithData("There is no user registered with this email", 401);
        }
        if ($userData->getPassword() != $requestParams["password"]) {
        	return $this->respondWithData("Wrong user password", 401);
        }
        # Create new user session
        $newUserSession = new UserSession();
        $newUserSession->setUserAccountId($userData->getId());
		$newUserSession->setToken($this->generateToken());
		$dateTime = new \DateTime();
		$newUserSession->setCreated($dateTime);
		$newUserSession->setExpired($dateTime->modify('+1 day'));
        $this->em->persist($newUserSession);
        $this->em->flush();
        # Build the response
        $response = [
            "user_id" => $newUserSession->getUserAccountId(),
            "token" => $newUserSession->getToken()
        ];

        return $this->respondWithData($response, 201);
    }

    /**
     * Generate the token
     * 
     * @param integer $bytes
     *
     * @return array
     */
    private function generateToken(int $bytes = 16): string
    {        
    	$token = openssl_random_pseudo_bytes($bytes);
		$token = bin2hex($token);

    	return $token;
    }
}