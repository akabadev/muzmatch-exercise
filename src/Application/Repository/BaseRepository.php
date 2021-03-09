<?php
declare(strict_types=1);

namespace App\Application\Repository;

use Doctrine\ORM\EntityManager;

abstract class BaseRepository
{
    const TABLE_USER = 'user_account';
    const TABLE_GENDER = 'gender';
    const TABLE_INTERESTED_GENDER = 'interested_in_gender';
    const TABLE_USER_PHOTO = 'user_photo';
    const TABLE_USER_MATCH = 'user_match';

    /**
     * @var EntityManager
     */
    protected $em;

    protected $connection;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->connection = $this->em->getConnection();
    }

    /**
     * @param string $sql
     * @param array  $parameters
     *
     * @return array
     */
    protected function executeQuery(string $sql, array $parameters = []):array 
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($parameters);
        
        return $stmt->fetchAll();
    }
}