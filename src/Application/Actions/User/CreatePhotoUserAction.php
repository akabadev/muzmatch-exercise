<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Domain\UserPhoto;

final class CreatePhotoUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        /** Validate user token */
        if ( !$this->tokenMiddleware->checkToken($this->request)) {
            return $this->respondWithData("Wrong token provided", 401);
        }
        $requestParams = $this->request->getQueryParams();
        # Create new photo
        $newUserPhoto = new UserPhoto();
        $newUserPhoto->setUserAccountId((int)$requestParams['user_id']);
        $newUserPhoto->setName($requestParams['name']);
        $newUserPhoto->setUrl($requestParams['url']);
        $dateTime = new \DateTime();
        $newUserPhoto->setCreated($dateTime);
        $this->em->persist($newUserPhoto);
        $this->em->flush();
        $response = [
            'response' => "New photo saved", 
        ];   

        return $this->respondWithData($response, 201);
    }
}