<?php

namespace Xsolve\NewsletterBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Xsolve\NewsletterBundle\Entity\RecipientListRepository")
 * @ORM\Table(
 *      name="recipient_lists",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="name_unique",
 *              columns={"name"}
 *          )
 *      }
 * )
 * @UniqueEntity(fields={"name"})
 */
class RecipientList
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     * @Assert\Length(min=4, max=64)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Recipient", mappedBy="list")
     */
    private $recipients;

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
     * Constructor
     */
    public function __construct()
    {
        $this->recipients = new ArrayCollection();
    }

    /**
     * Add recipients
     *
     * @param  \Xsolve\NewsletterBundle\Entity\Recipient $recipients
     * @return ReciepientList
     */
    public function addRecipient(\Xsolve\NewsletterBundle\Entity\Recipient $recipients)
    {
        $this->recipients[] = $recipients;

        return $this;
    }

    /**
     * Remove recipients
     *
     * @param \Xsolve\NewsletterBundle\Entity\Recipient $recipients
     */
    public function removeRecipient(\Xsolve\NewsletterBundle\Entity\Recipient $recipients)
    {
        $this->recipients->removeElement($recipients);
    }

    /**
     * Get recipients
     *
     * @return Collection
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * Set name
     *
     * @param  string        $name
     * @return RecipientList
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
