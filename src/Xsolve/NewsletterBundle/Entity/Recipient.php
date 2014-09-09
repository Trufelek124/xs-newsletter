<?php

namespace Xsolve\NewsletterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="Xsolve\NewsletterBundle\Entity\RecipientRepository")
 * @ORM\Table(
 *      name="recipients",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="list_mail_unique",
 *              columns={"list_id", "mail"}
 *          )
 *      }
 * )
 * @UniqueEntity(fields={"list", "mail"})
 */
class Recipient
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="RecipientList", inversedBy="recipients")
     */
    private $list;

    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\NotBlank
     * @Assert\Email
     * @Assert\Length(max=128)
     */
    private $mail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

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
     * Set mail
     *
     * @param  string    $mail
     * @return Recipient
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set active
     *
     * @param  boolean   $active
     * @return Recipient
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set list
     *
     * @param  \Xsolve\NewsletterBundle\Entity\RecipientList $list
     * @return Recipient
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
}
