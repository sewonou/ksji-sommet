<?php

namespace App\Entity;

use App\Repository\DayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DayRepository::class)
 */
class Day
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $scheduleAt;

    /**
     * @ORM\OneToMany(targetEntity=DayEvent::class, mappedBy="day")
     */
    private $dayEvents;

    public function __construct()
    {
        $this->dayEvents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getScheduleAt(): ?\DateTimeInterface
    {
        return $this->scheduleAt;
    }

    public function setScheduleAt(?\DateTimeInterface $scheduleAt): self
    {
        $this->scheduleAt = $scheduleAt;

        return $this;
    }

    public function getInfo()
    {
        return $this->title ;
    }

    /**
     * @return Collection|DayEvent[]
     */
    public function getDayEvents(): Collection
    {
        return $this->dayEvents;
    }

    public function addDayEvent(DayEvent $dayEvent): self
    {
        if (!$this->dayEvents->contains($dayEvent)) {
            $this->dayEvents[] = $dayEvent;
            $dayEvent->setDay($this);
        }

        return $this;
    }

    public function removeDayEvent(DayEvent $dayEvent): self
    {
        if ($this->dayEvents->contains($dayEvent)) {
            $this->dayEvents->removeElement($dayEvent);
            // set the owning side to null (unless already changed)
            if ($dayEvent->getDay() === $this) {
                $dayEvent->setDay(null);
            }
        }

        return $this;
    }
}
