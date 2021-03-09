<?php
declare(strict_types=1);

namespace App\Domain;

/**
 * @Entity()
 * @Table(name="user_session")
 */
class UserSession
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
     * @Column(type="integer", name="user_account_id", length=11, nullable=false)
     */
    private $userAccountId;

    /**
     * @var string
     *
     * @Column(type="string", name="token", length=250, nullable=false)
     */
    private $token;

    /**
     * @var datetime
     *
     * @Column(type="datetime", name="created", nullable=false)
     */
    private $created;

    /**
     * @var datetime
     *
     * @Column(type="datetime", name="expired", nullable=false)
     */
    private $expired;

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
    public function getUserAccountId(): int
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
    public function setUserAccountId(int $userAccountId): void
    {
        $this->userAccountId = $userAccountId;
    }


    /**
     * Get token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return void
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getExpired(): \DateTime
    {
        return $this->expired;
    }

    /**
     * @param \DateTime $expired
     */
    public function setExpired(\DateTime $expired): void
    {
        $this->expired = $expired;
    }
}