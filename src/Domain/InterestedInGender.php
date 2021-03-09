<?php
declare(strict_types=1);

namespace App\Domain;

/**
 * @Entity()
 * @Table(name="interested_in_gender")
 */
class InterestedInGender
{
    /**
     * @var int
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @Column(type="integer", name="user_account_id", nullable=false)
     */
    private $userAccountId;

    /**
     * @var int
     *
     * @Column(type="integer", name="gender_id", nullable=false)
     */
    private $genderId;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get user_account_id
     *
     * @return integer
     */
    public function getUserAccountId(): string
    {
        return $this->userAccountId;
    }

    /**
     * Set name.
     *
     * @param integer $userAccountId
     *
     * @return void
     */
    public function setUserAccountId($userAccountId): void
    {
        $this->userAccountId = $userAccountId;
    }

    /**
     * Get gender_id
     *
     * @return integer
     */
    public function getGenderId(): int
    {
        return $this->userAccountId;
    }

    /**
     * Set gender_id
     *
     * @param integer $genderId
     *
     * @return void
     */
    public function setGenderId($genderId): void
    {
        $this->genderId = $genderId;
    }
}