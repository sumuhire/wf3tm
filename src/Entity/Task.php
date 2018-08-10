<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

//to link a homemade repository with a class, add the path in entity

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string", length=36)
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    
    /**
     * @ORM\Column(type="text")
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $author;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $creationDate;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $priority;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $project;
    
    public function __construct()
    {
        $this->creationDate = new \DateTime();
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAuthor() : ?User
    {
        return $this->author;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
        return $this;
    }

    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
    
    public function getProject(): ?Project
    {
        return $this->project;
    }
    
    public function setProject(?Project $project): self
    {
        $this->project = $project;
        
        return $this;
    }
}

