<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Doctor
{
	/** @var  int */
	private $id;
	/** @var  string */
	private $name;
	/** @var  ArrayCollection */
	private $patients;

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return Patient
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Patient
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

        /**
        * @return ArrayCollection
        */
       public function getPatients()
       {
           return $this->patients;
       }

       /**
        * @param ArrayCollection $patients
        */
       public function setPatients(ArrayCollection $patients)
       {
           $this->patients = $patients;
       }

       /**
        * @param Patient $patient
        */
       public function addPatient(\AppBundle\Entity\Patient $patient)
       {
           if (! $this->patients->contains($patient)) {
               $this->patients->add($patient);
               $patient->setDoctor($this);
           }

           return $this->patients;
       }

       /**
        * @param Patient $patient
        */
       public function removePatient(AppBundle\Entity\Patient $patient)
       {
           if ($this->patients->contains($patient)) {
               $this->patients->removeElement($patient);
           }

           return $this->patients;
       }

        public function __construct()
        {
            $this->patients = new ArrayCollection();
        }

}