<?php
declare(strict_types=1);

namespace App\Domain;

/**
 * @Entity()
 * @Table(name="user_match")
 */
class UserMatch
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
     * @var int
     *
     * @Column(type="integer", name="user_referral_id", length=11, nullable=false)
     */
    private $userReferralId;

    /**
     * @var int
     *
     * @Column(type="integer", name="preference", length=11, nullable=false)
     */
    private $preference;

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
    public function setUserAccountId(int $userAccountId): void
    {
        $this->userAccountId = $userAccountId;
    }

    /**
     * Get user_referral_id
     *
     * @return integer
     */
    public function getUserReferralId(): int
    {
        return $this->userReferralId;
    }

    /**
     * Set user_referral_id
     *
     * @param integer $userReferralId
     *
     * @return void
     */
    public function setUserReferralId(int $userReferralId): void
    {
        $this->userReferralId = $userReferralId;
    }

    /**
     * Get preference
     *
     * @return integer
     */
    public function getPreference(): int
    {
        return $this->preference;
    }

    /**
     * Set preference
     *
     * @param integer $preference
     *
     * @return void
     */
    public function setPreference(int $preference): void
    {
        $this->preference = $preference;
    }
}