<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Classroom;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
 //  #[ORM\GeneratedValue]    1  zidna
    #[ORM\Column]
    private ?int $nce = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(nullable: true)]
    private ?float $moyenne = null;

    #[ORM\ManyToOne(inversedBy: 'Student')]
   // #[ORM\JoinColumn(onDelete: "CASCADE")] // pour quand on supprime classrom     2   zidna
    private ?Classroom $Classroom = null;

    public function getNce(): ?int
    {
        return $this->nce;
    }

    public function setNce(int $nce): self
    {
        $this->nce = $nce;

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

    public function getMoyenne(): ?float
    {
        return $this->moyenne;
    }

    public function setMoyenne(?float $moyenne): self
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    public function getClassroom(): ?Classroom
    {
        return $this->Classroom;
    }

    public function setClassroom(?Classroom $Classroom): self
    {
        $this->Classroom = $Classroom;

        return $this;
    }

}
