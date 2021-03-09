<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Domain\User;
use App\Domain\Gender;
use App\Domain\InterestedInGender;

final class CreateUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $requestParams = $this->request->getQueryParams();
        /** Control the user is not been registered already */
        if ($this->userRepository->searchUserByEmail($requestParams["email"]) OR !filter_var($requestParams["email"], FILTER_VALIDATE_EMAIL)) {
            return $this->respondWithData(["Wrong email submitted"], 401);
        }
        # Get all the gender data.
        $genderData = $this->em
            ->getRepository(Gender::class)
            ->findAll();
        $genderData = $this->filterGenderData($genderData, $requestParams);
        # Create a new User
        $newUser = new User();
        $newUser->setEmail($requestParams["email"]);
        $newUser->setPassword(htmlspecialchars($requestParams["password"]));
        $newUser->setName($requestParams["name"]);
        $newUser->setGenderId($genderData[$requestParams["gender"]]);
        $newUser->setAge($requestParams["age"]);
        $newUser->setLatitude($requestParams["latitude"]);
        $newUser->setLongitude($requestParams["longitude"]);
        $this->em->persist($newUser);
        $this->em->flush();
        # Create entry in InterestedInGender
        $interestedInGender = new InterestedInGender();
        $interestedInGender->setUserAccountId($newUser->getId());
        $interestedInGender->setGenderId($genderData[$requestParams["interest_gender"]]);
        $this->em->persist($interestedInGender);
        $this->em->flush();
        # Build the response
        $response = [
            "id" => $newUser->getId(),
            "email" => $newUser->getEmail(),
            "name" => $newUser->getName(),
            "gender" => $requestParams["gender"],
            "age" => (int)$requestParams["age"]
        ];

        return $this->respondWithData($response, 201);
    }

    /**
     * @param object $genderData
     * @param array  $requestParams
     *
     * @return array
     */
    private function filterGenderData($genderData, array $requestParams): array
    {
        $genderSelected = [];
        foreach ($genderData as $keyGender => $valueGender) {
            if ($valueGender->getName() == $requestParams['gender'] || $valueGender->getName() == $requestParams['interest_gender']) {
                $genderSelected[$valueGender->getName()] = $valueGender->getId();
            }
        }

        return $genderSelected;
    }
}