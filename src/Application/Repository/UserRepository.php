<?php
declare(strict_types=1);

namespace App\Application\Repository;

final class UserRepository extends BaseRepository
{
	/**
     * @param array  $usersId
     * @param array  $requestParams
     * @param array  $orderProfiles
     *
     * @return array
     */
	public function searchUserProfiles(
		array $usersId, 
		array $requestParams, 
		array $orderProfiles = null
	): array
	{
		$parameters = [];
		$usersId = implode(', ', $usersId);
		$orderProfiles = (is_null($orderProfiles)) ? null : implode(', ', $orderProfiles);
		# Query build 
		$sql = 'SELECT ua.id AS id, ua.name, ua.email, ua.age
			FROM '.self::TABLE_USER.' AS ua ';
		# Search by gender	
		if (isset($requestParams['gender'])) {
			$sql .= 'INNER JOIN '.self::TABLE_GENDER.' as g
				ON g.id = ua.gender_id ';
		}
		# Required profiles ids
		$sql .= 'WHERE ua.id IN ('.$usersId.') ';
		# Search by gender
		if (isset($requestParams['gender'])) {
			$sql .= 'AND g.name = :gender ';
			$parameters["gender"] = $requestParams['gender'];
		}
		# Search by age
		if (isset($requestParams['age'])) {
			$sql .= 'AND ua.age = :age ';
			$parameters["age"] = $requestParams['age'];
		}
		# Order profiles
		if (!is_null($orderProfiles)) {
			$sql .= 'ORDER BY FIELD(ua.id, '.$orderProfiles.')';
		}

		return $this->executeQuery($sql, $parameters);
	}

	/**
     * @param string $userEmail
     *
     * @return array
     */
	public function searchUserByEmail(string $userEmail): array
	{
		$sql = 'SELECT ua.id, ua.name, ua.email, g.name AS gender, ua.age 
		    FROM '.self::TABLE_USER.' AS ua
		    INNER JOIN '.self::TABLE_GENDER.' AS g
		    ON g.id = ua.gender_id
		    WHERE ua.email = :email';
		$parameters = [
		    'email' => $userEmail
		];

		return $this->executeQuery($sql, $parameters);
	}

	/**
     * @param integer $userId
     *
     * @return array
     */
	public function getPotentialProfilesByUser(int $userId): array
	{
		$sql = 'SELECT other_ua.id AS id
			FROM '.self::TABLE_USER.' AS other_ua
			INNER JOIN '.self::TABLE_INTERESTED_GENDER.' AS ig 
			ON ig.gender_id = other_ua.gender_id
			INNER JOIN '.self::TABLE_USER_MATCH.' AS um
			ON um.user_account_id = other_ua.id
			INNER JOIN '.self::TABLE_USER.' AS main_ua
			ON main_ua.id = ig.user_account_id
			WHERE main_ua.id = :userId
			AND um.user_referral_id = :userId
			AND um.preference = 1
			OR um.user_referral_id = other_ua.id AND um.user_account_id = :userId';
		$parameters = [
			"userId" => $userId
		];
		
		return $this->executeQuery($sql, $parameters);
	}

	/**
     * @param array $usersId
     * @param float $userLatitude
     * @param float $userLongitude
     *
     * @return array
     */
	public function getUsersDistanceById(
		array $usersId, 
		float $userLatitude, 
		float $userLongitude
	): array
	{
		$usersId = implode(', ', $usersId);
		/**
		 * 69.1 is the conversion factor for miles to latitude degrees. 
		 * 57.3 is roughly 180/pi, so that's conversion from degrees to radians  * for the cosine function. 
		 * 25 is the search radius in miles.
		 */
		$sql = 'SELECT id, name, latitude, longitude, SQRT(
		    POW(69.1 * (latitude - :userLatitude), 2) +
		    POW(69.1 * (:userLongitude - longitude) * COS(latitude / 57.3), 2)) AS distance
			FROM user_account
			WHERE id IN ('.$usersId.')
			HAVING distance < 25 
			ORDER BY distance';
		$parameters = [
			"userLatitude" => $userLatitude,
			"userLongitude" => $userLongitude
		];
		
		return $this->executeQuery($sql, $parameters);
	}
}