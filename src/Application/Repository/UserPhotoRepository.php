<?php
declare(strict_types=1);

namespace App\Application\Repository;

final class UserPhotoRepository extends BaseRepository
{
	/**
     * @param array $usersId
     *
     * @return array
     */
	public function searchUserPhotosById(array $usersId)
	{
		$usersId = implode(', ', $usersId);
		$sql = 'SELECT id AS photo_id, user_account_id, name AS photo_name, url
			FROM '.self::TABLE_USER_PHOTO.'
			WHERE user_account_id IN ('.$usersId.')';
		
		return $this->executeQuery($sql);
	}
}