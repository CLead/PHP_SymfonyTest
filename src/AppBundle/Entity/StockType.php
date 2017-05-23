<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="StockType")
*/
class StockType
{
	/**
	  * @ORM\Column(type="integer")
	  * @ORM\Id
	  * @ORM\GeneratedValue(strategy="AUTO")
	  */
	private $ID;

	/**
	  * @ORM\Column(type="string", length=100)
	  */
	private $Description;

	/**
	  * @ORM\Column(type="boolean", length=100)
	  */	
	private $Deleted;


    /**
     * Get iD
     *
     * @return integer
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return StockType
     */
    public function setDescription($description)
    {
        $this->Description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return StockType
     */
    public function setDeleted($deleted)
    {
        $this->Deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->Deleted;
    }
}
