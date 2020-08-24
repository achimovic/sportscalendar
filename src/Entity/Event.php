<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
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
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity=Calendar::class, inversedBy="events")
     * @ORM\JoinTable(name="event_calendar",
     *     joinColumns={@ORM\JoinColumn(name="_event", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="_calendar", referencedColumnName="id")}
     * )
     */
    private $calendars;

    /**
     * @ORM\ManyToOne(targetEntity=League::class, inversedBy="events")
     * @ORM\JoinColumn(name="_league", referencedColumnName="id")
     */
    private $league;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="events")
     * @ORM\JoinColumn(name="_sport", referencedColumnName="id")
     */
    private $sport;

    /**
     * @ORM\ManyToMany(targetEntity=Team::class, inversedBy="events")
     * @ORM\JoinTable(name="event_team",
     *     joinColumns={@ORM\JoinColumn(name="_event", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="_team", referencedColumnName="id")}
     * )
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity=Athlete::class, inversedBy="events")
     * @ORM\JoinTable(name="event_athlete",
     *     joinColumns={@ORM\JoinColumn(name="_event", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="_athlete", referencedColumnName="id")}
     * )
     */
    private $athletes;

    public function __construct()
    {
        $this->calendars = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->athletes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTitle(): ?string
    {
        if (null === $this->name) {
            $parts = [];
            if ($this->getSport()) {
                $parts[] = $this->getSport()->getName();
            }
            if ($this->getLeague()) {
                $parts[] = $this->getLeague()->getName();
            }
            if ($this->getTeams()->count() > 0 && $this->getAthletes()->count() < 4) {
                foreach ($this->getTeams() as $team) {
                    $parts[] = $team->getName();
                }
            }
            if ($this->getAthletes()->count() > 0 && $this->getAthletes()->count() < 4) {
                foreach ($this->getAthletes() as $athlete) {
                    $parts[] = $athlete->getName();
                }
            }

            return implode(' - ', $parts);
        }
        return $this->name;
    }


    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|Calendar[]
     */
    public function getCalendars(): Collection
    {
        return $this->calendars;
    }

    public function addCalendar(Calendar $calendar): self
    {
        if (!$this->calendars->contains($calendar)) {
            $this->calendars[] = $calendar;
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): self
    {
        if ($this->calendars->contains($calendar)) {
            $this->calendars->removeElement($calendar);
        }

        return $this;
    }

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
    {
        $this->league = $league;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
        }

        return $this;
    }

    /**
     * @return Collection|Athlete[]
     */
    public function getAthletes(): Collection
    {
        return $this->athletes;
    }

    public function addAthlete(Athlete $athlete): self
    {
        if (!$this->athletes->contains($athlete)) {
            $this->athletes[] = $athlete;
        }

        return $this;
    }

    public function removeAthlete(Athlete $athlete): self
    {
        if ($this->athletes->contains($athlete)) {
            $this->athletes->removeElement($athlete);
        }

        return $this;
    }
}
