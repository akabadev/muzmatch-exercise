<?php
declare(strict_types=1);

namespace App\Application\Repository;

final class UserMatchRepository extends BaseRepository
{
	/**
     * Return a list with the profiles ranking
     *
     * @return array
     */
	public function getUsersRanking(): array
	{
		$sql = 'SELECT um.user_referral_id AS id, ua.name, SUM(um.user_referral_id) popularity
			FROM '.SELF::TABLE_USER_MATCH.' AS um
			INNER JOIN '.SELF::TABLE_USER.' AS ua
			ON ua.id = um.user_referral_id
			WHERE um.preference = 1
			GROUP BY um.user_referral_id
			ORDER BY popularity DESC';
			
		return $this->executeQuery($sql);
	}
}