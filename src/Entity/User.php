<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields={"eamil"},
 * message="L'email existe deja"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $eamil;

    /**
     * @ORM\Column(type="string", length=255)
     * * @Assert\Length(min=4,minMessage="Veuillez saisir minimun 4 caracteres") 
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8,minMessage="Veuillez saisir minimun 8 caracteres") 
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEamil(): ?string
    {
        return $this->eamil;
    }

    public function setEamil(string $eamil): self
    {
        $this->eamil = $eamil;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function eraseCredentials(){}

    public function getSalt(){}

    public function getRoles(){
        return ['ROLE_USER'];
    }
}
