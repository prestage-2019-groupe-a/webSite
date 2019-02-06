<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *  fields={"email"},
 *  message="Cette adresse email existe déjà")
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
     * @Assert\NotBlank(message="Veuillez rentrer votre prénom")
     * @Assert\Length(min=3, minMessage="Votre prénom doit faire 3 caractères minimum")
     * @Assert\Length(max=20, maxMessage="Votre prénom doit faire 20 caractères maximum")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez rentrer votre nom de famille")
     * @Assert\Length(min=3, minMessage="Votre nom de famille doit faire 3 caractères minimum")
     * @Assert\Length(max=20, maxMessage="Votre nom de famille doit faire 20 caractères maximum")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez rentrer votre email")
     * @Assert\Email(message="Email invalide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez rentrer votre mot de passe")
     * @Assert\Length(min=8, minMessage="Le mot de passe doit faire au moins 8 caractères")
     * @Assert\Length(max=30, maxMessage="Le mot de passe peut faire 30 caractères maximum")
     */
    private $hash;

    /**
     * @Assert\EqualTo(propertyPath="hash", message="Les mots de passe ne correspondent pas")
     */
    private $confirmPassword;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Student", mappedBy="user", cascade={"persist", "remove"})
     */
    private $student;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Coach", mappedBy="user", cascade={"persist", "remove"})
     */
    private $coach;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    public function getFullName() {

        return $this->name . " " . $this->lastName;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {

        if(empty($this->image)) {

            $this->image = "/image/defaultUser.png";
        }
    }

    public function getRoles() {

        return ['ROLE_USER'];
    }

    public function getPassword() {

        return $this->hash;
    }

    public function getSalt() {}

    public function getUsername() {

        return $this->email;
    }

    public function eraseCredentials() {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): self
    {
        $this->student = $student;

        // set the owning side of the relation if necessary
        if ($this !== $student->getUser()) {
            $student->setUser($this);
        }

        return $this;
    }

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(Coach $coach): self
    {
        $this->coach = $coach;

        // set the owning side of the relation if necessary
        if ($this !== $coach->getUser()) {
            $coach->setUser($this);
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }
    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;
        return $this;
    }
}
