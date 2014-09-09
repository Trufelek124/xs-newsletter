<?php

namespace Xsolve\NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="dispatches")
  */
class Dispatch
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Message")
     * @Assert\NotBlank
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="RecipientList")
     * @Assert\NotBlank
     */
    private $list;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalTasks;

    /**
     * @ORM\Column(type="integer")
     */
    private $doneTasks;

    /**
     * @ORM\Column(type="integer")
     */
    private $failedTasks;

    public function incDoneTasks()
    {
        $this->setDoneTasks($this->getDoneTasks()+1);
    }

    public function incFailedTasks()
    {
        $this->setFailedTasks($this->getFailedTasks()+1);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set totalTasks
     *
     * @param  integer  $totalTasks
     * @return Dispatch
     */
    public function setTotalTasks($totalTasks)
    {
        $this->totalTasks = $totalTasks;

        return $this;
    }

    /**
     * Get totalTasks
     *
     * @return integer
     */
    public function getTotalTasks()
    {
        return $this->totalTasks;
    }

    /**
     * Set doneTasks
     *
     * @param  integer  $doneTasks
     * @return Dispatch
     */
    public function setDoneTasks($doneTasks)
    {
        $this->doneTasks = $doneTasks;

        return $this;
    }

    /**
     * Get doneTasks
     *
     * @return integer
     */
    public function getDoneTasks()
    {
        return $this->doneTasks;
    }

    /**
     * Set failedTasks
     *
     * @param  integer  $failedTasks
     * @return Dispatch
     */
    public function setFailedTasks($failedTasks)
    {
        $this->failedTasks = $failedTasks;

        return $this;
    }

    /**
     * Get failedTasks
     *
     * @return integer
     */
    public function getFailedTasks()
    {
        return $this->failedTasks;
    }

    /**
     * Set message
     *
     * @param  \Xsolve\NewsletterBundle\Entity\Message $message
     * @return Dispatch
     */
    public function setMessage(\Xsolve\NewsletterBundle\Entity\Message $message = null)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return \Xsolve\NewsletterBundle\Entity\Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set list
     *
     * @param  \Xsolve\NewsletterBundle\Entity\RecipientList $list
     * @return Dispatch
     */
    public function setList(\Xsolve\NewsletterBundle\Entity\RecipientList $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return \Xsolve\NewsletterBundle\Entity\RecipientList
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * Set date
     *
     * @param  \DateTime $date
     * @return Dispatch
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
