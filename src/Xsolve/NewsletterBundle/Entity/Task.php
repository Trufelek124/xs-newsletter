<?php

namespace Xsolve\NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Xsolve\NewsletterBundle\Entity\TaskRepository")
 * @ORM\Table(
 *      name="tasks",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="dispatch_recipient_unique",
 *              columns={"dispatch_id", "recipient_id"}
 *          )
 *      }
 * )
 */
class Task
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Dispatch")
     */
    private $dispatch;

    /**
     * @ORM\ManyToOne(targetEntity="Recipient")
     */
    private $recipient;

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
     * Set message
     *
     * @param  \Xsolve\NewsletterBundle\Entity\Message $message
     * @return Task
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
     * Set dispatch
     *
     * @param  \Xsolve\NewsletterBundle\Entity\Dispatch $dispatch
     * @return Task
     */
    public function setDispatch(\Xsolve\NewsletterBundle\Entity\Dispatch $dispatch = null)
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    /**
     * Get dispatch
     *
     * @return \Xsolve\NewsletterBundle\Entity\Dispatch
     */
    public function getDispatch()
    {
        return $this->dispatch;
    }

    /**
     * Set recipient
     *
     * @param  \Xsolve\NewsletterBundle\Entity\Recipient $recipient
     * @return Task
     */
    public function setRecipient(\Xsolve\NewsletterBundle\Entity\Recipient $recipient = null)
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return \Xsolve\NewsletterBundle\Entity\Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }
}
