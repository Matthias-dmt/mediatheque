<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=MeetUp::class, mappedBy="employee")
     */
    private $organizes;

    /**
     * @ORM\OneToMany(targetEntity=Maintenance::class, mappedBy="maintainer")
     */
    private $maintenances;

    public function __construct()
    {
        $this->organizes = new ArrayCollection();
        $this->maintenances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|MeetUp[]
     */
    public function getOrganizes(): Collection
    {
        return $this->organizes;
    }

    public function addOrganize(MeetUp $organize): self
    {
        if (!$this->organizes->contains($organize)) {
            $this->organizes[] = $organize;
            $organize->setEmployee($this);
        }

        return $this;
    }

    public function removeOrganize(MeetUp $organize): self
    {
        if ($this->organizes->contains($organize)) {
            $this->organizes->removeElement($organize);
            // set the owning side to null (unless already changed)
            if ($organize->getEmployee() === $this) {
                $organize->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Maintenance[]
     */
    public function getMaintenances(): Collection
    {
        return $this->maintenances;
    }

    public function addMaintenance(Maintenance $maintenance): self
    {
        if (!$this->maintenances->contains($maintenance)) {
            $this->maintenances[] = $maintenance;
            $maintenance->setMaintainer($this);
        }

        return $this;
    }

    public function removeMaintenance(Maintenance $maintenance): self
    {
        if ($this->maintenances->contains($maintenance)) {
            $this->maintenances->removeElement($maintenance);
            // set the owning side to null (unless already changed)
            if ($maintenance->getMaintainer() === $this) {
                $maintenance->setMaintainer(null);
            }
        }

        return $this;
    }
}