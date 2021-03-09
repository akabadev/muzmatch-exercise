<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Domain\User;

final class ListUserAction extends UserAction
{
    /**
     *  {@inheritdoc}
     */
    protected function action(): Response
    {
        /** Validate user token */
        if (!$this->tokenMiddleware->checkToken($this->request)) {
            return $this->respondWithData("Wrong token provided", 401);
        } 
    	$requestParams = $this->request->getQueryParams();
        $orderProfiles = null;
        $resultInterestProfiles = [];
        /**
         * Search potential profiles
         * This is not a list of profiles. This returns a list of 
         * profiles swiped or that have any type of interest in the user.
         * 
         * 1st Get all the potential profiles for the user by default
         * 2nd (Optional) Based on the previous result get the distance 
         * of each user.
         * 3rd (Optional) Based on the 1st step by default or 2nd step, 
         * it order the users by popularity.
         * 4th Get the users profiles based on the id list provided 
         * and optional parameters.
         * 5th Get the photos of each profile.
         */

        /** 
         * Step 1
         * Get all the potential profiles for the user by default
         * NOTE: In case we want to apply pagination e should add the limit here.
         */
        $resultInterestProfiles = $this->userRepository->getPotentialProfilesByUser((int)$requestParams['user_id']);
        $resultInterestProfiles = $this->filterUserAccountIds($resultInterestProfiles);
        if (!$resultInterestProfiles) {
            return $this->respondWithData(['No matches yet! Keep using the app.'], 200);
        }

        /** 
         * Step 2 (Optional)
         * Based on the previous result get the distance of each user.
         */
        if (isset($requestParams['location']) && $resultInterestProfiles) {
            $userData = $this->em
                ->getRepository(User::class)
                ->findOneBy(['id' => (int)$requestParams['user_id']]);
            $usersDistanceList = $this->userRepository->getUsersDistanceById($resultInterestProfiles, $userData->getLatitude(), $userData->getLongitude());
            $usersDistanceList = $this->filterUserAccountIds($usersDistanceList);
            $orderProfiles = array_intersect($usersDistanceList, $resultInterestProfiles);
            unset($usersDistanceList);
        }

        /** 
         * Step 3 (Optional)
         * Order the users by popularity.
         * NOTE: This point should be save in cache and take in 
         * consideration other parameters like gender.
         */
        if (isset($requestParams['attractiveness']) && $resultInterestProfiles) {
            $rankingUsersList = $this->userMatchRepository->getUsersRanking();
            $rankingUsersList = $this->filterUserAccountIds($rankingUsersList);
            $orderProfiles = array_intersect($rankingUsersList, $resultInterestProfiles);
            unset($rankingUsersList);
        }

        /** 
         * Step 4 
         * Get the users profiles based on the id list provided 
         * and optional parameters.
         */
        $resultInterestProfiles = $this->userRepository->searchUserProfiles($resultInterestProfiles, $requestParams, $orderProfiles);

        /** 
         * Step 5 
         * Get the photos of each profile.
         */
        if ($resultInterestProfiles) {
            $picturesProfiles = $usersInterestProfile = $this->filterUserAccountIds($resultInterestProfiles);
            $picturesProfiles = $this->userPhotoRepository->searchUserPhotosById($picturesProfiles);
            # Built the response with the photos
            $resultInterestProfiles = $this->formatListResponse($resultInterestProfiles, $picturesProfiles);
            unset($picturesProfiles);
        }
        $response = [
            'profiles' => $resultInterestProfiles
        ];        

        return $this->respondWithData($response, 200);
    }

    /**
     * @param array $profiles
     * @param array $photos
     *
     * @return array
     */
    private function formatListResponse(array $profiles, array $photos): array
    {
        $resultProfiles = [];
        # Format profiles        
        foreach ($profiles as $keyProfile => $valueProfile) {
            $arrayKeyProfile = "profile_".$valueProfile["id"];
            $resultProfiles[$arrayKeyProfile]["id"] = $valueProfile["id"];
            $resultProfiles[$arrayKeyProfile]["name"] = $valueProfile["name"];
            $resultProfiles[$arrayKeyProfile]["email"] = $valueProfile["email"];
            $resultProfiles[$arrayKeyProfile]["age"] = $valueProfile["age"];
            $resultProfiles[$arrayKeyProfile]["photos_".$arrayKeyProfile] = [];
        }
        # Format photos and add profile photos
        foreach ($photos as $keyPhoto => $valuePhoto) {
            $resultPhoto = [];
            $resultPhoto["id"] = $valuePhoto["photo_id"];
            $resultPhoto["name"] = $valuePhoto["photo_name"];
            $resultPhoto["url"] = $valuePhoto["url"];
            $resultProfiles["profile_".$valuePhoto["user_account_id"]]["photos_profile_".$valuePhoto["user_account_id"]][] = $resultPhoto;
        }

        return $resultProfiles;
    }

    /**
     * Format the array and return the users profiles ids.
     * 
     * @param array $usersInterestProfile
     *
     * @return array
     */
    private function filterUserAccountIds(array $usersInterestProfile): array
    {
        $usersProfiles = [];
        foreach ($usersInterestProfile as $key => $value) {
            $usersProfiles[] = (int)$value["id"];
        }

        return $usersProfiles;
    }
}