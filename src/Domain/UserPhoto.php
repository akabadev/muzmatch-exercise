<?php
declare(strict_types=1);

namespace App\Domain;

/**
 * @Entity()
 * @Table(name="user_photo")
 */
class UserPhoto
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
     * @Column(type="string", name="name", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @Column(type="string", name="url", length=250, nullable=false)
     */
    private $url;

    /**
     * @var datetime
     *
     * @Column(type="datetime", name="created", nullable=false)
     */
    private $created;

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
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return void
     */
    public function setUrl($url): void
    {
        $this->url = $url;
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
}