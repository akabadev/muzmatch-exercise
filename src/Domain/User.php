<?php
declare(strict_types=1);

namespace App\Domain;

/**
 * @Entity()
 * @Table(name="user_account")
 */
class User
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
     * @var string
     *
     * @Column(type="string", name="email", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(type="string", name="password", length=250, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @Column(type="string", name="name", length=100, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @Column(type="integer", name="gender_id", length=11, nullable=false)
     * @OneToOne(targetEntity="Gender")
     * @JoinColumn(name="id")
     */
    private $genderId;

    /**
     * @var int
     *
     * @Column(type="integer", name="age", length=11, nullable=false)
     */
    private $age;

    /**
     * @var decimal
     *
     * @Column(type="decimal", name="latitude", nullable=false)
     */
    private $latitude;

    /**
     * @var decimal
     *
     * @Column(type="decimal", name="longitude", nullable=false)
     */
    private $longitude;

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
     * Get email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password): void
    {
        $this->password = $password;
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
     * Get gender_id
     *
     * @return integer
     */
    public function getGenderId(): int
    {
        return $this->genderId;
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

    /**
     * Get age
     *
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return void
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return (float)$this->latitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return void
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return (float)$this->longitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return void
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }
}