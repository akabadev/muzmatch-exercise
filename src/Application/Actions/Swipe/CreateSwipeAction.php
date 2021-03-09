<?php
declare(strict_types=1);

namespace App\Application\Actions\Swipe;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;
use App\Domain\UserMatch;

final class CreateSwipeAction extends SwipeAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        # Validate user token
        if( !$this->tokenMiddleware->checkToken($this->request) ){
            return $this->respondWithData("Wrong token provided", 401);
        }
        $requestParams = $this->request->getQueryParams();
    	$userMatchData = $this->em
            ->getRepository(UserMatch::class)
            ->findOneBy(['userAccountId' => $requestParams['user_id'], 'userReferralId' => $requestParams['referral_id']]);
        # Create or update a match
        $preference = is_null($userMatchData) ? $this->setNewMatch($requestParams) : $this->updateMatch($requestParams, $userMatchData);
        # Check if is a match 
        $response = ($preference != true) ? ['response' => "NO"] : $this->checkReferralUserPreference($requestParams);

        return $this->respondWithData($response, 201);
    }

    /**
     * Set new match
     *
     * @param array $requestParams
     *
     * @return int
     */
    private function setNewMatch(array $requestParams): int
    {
        $newUserMatch = new UserMatch();
        $newUserMatch->setUserAccountId((int)$requestParams['user_id']);
        $newUserMatch->setUserReferralId((int)$requestParams['referral_id']);
        $newUserMatch->setPreference((int)$requestParams['swipe']);
        $this->em->persist($newUserMatch);
        $this->em->flush();

        return $newUserMatch->getPreference();
    }

    /**
     * Update match
     *
     * @param array  $requestParams
     * @param object $userMatchData
     *
     * @return int
     */
    private function updateMatch(array $requestParams, $userMatchData): int
    {
        $userMatchData->setPreference((int)$requestParams['swipe']);
        $this->em->persist($userMatchData);
        $this->em->flush();

        return $userMatchData->getPreference();
    }

    /**
     * Update match
     *
     * @param array  $requestParams
     *
     * @return array
     */
    public function checkReferralUserPreference(array $requestParams): array
    {
        $userMatchData = $this->em
            ->getRepository(UserMatch::class)
            ->findOneBy(['userAccountId' => $requestParams['referral_id'], 'userReferralId' => $requestParams['user_id']]);
        $preference = is_null($userMatchData) ? "NO" : ($userMatchData->getPreference() != true) ? "NO" : "YES";

        return ['response' => $preference];
    }
}