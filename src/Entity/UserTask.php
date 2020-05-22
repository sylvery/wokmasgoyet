<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserTaskRepository")
 */
class UserTask
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $completionDate;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\AppUser", inversedBy="userTasks")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="tasks")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TaskMilestones", mappedBy="task", cascade={"all"})
     */
    private $taskMilestones;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $priority;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->taskMilestones = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return Collection|AppUser[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(AppUser $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(AppUser $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

        return $this;
    }

    public function getCompletionDate(): ?\DateTimeInterface
    {
        return $this->completionDate;
    }

    public function setCompletionDate(?\DateTimeInterface $completionDate): self
    {
        $this->completionDate = $completionDate;

        return $this;
    }

    public function getOwner(): ?Member
    {
        return $this->owner;
    }

    public function setOwner(?Member $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|TaskMilestones[]
     */
    public function getTaskMilestones(): Collection
    {
        return $this->taskMilestones;
    }

    public function addTaskMilestone(TaskMilestones $taskMilestone): self
    {
        if (!$this->taskMilestones->contains($taskMilestone)) {
            $this->taskMilestones[] = $taskMilestone;
            $taskMilestone->setTask($this);
        }

        return $this;
    }

    public function removeTaskMilestone(TaskMilestones $taskMilestone): self
    {
        if ($this->taskMilestones->contains($taskMilestone)) {
            $this->taskMilestones->removeElement($taskMilestone);
            // set the owning side to null (unless already changed)
            if ($taskMilestone->getTask() === $this) {
                $taskMilestone->setTask(null);
            }
        }

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }
}
