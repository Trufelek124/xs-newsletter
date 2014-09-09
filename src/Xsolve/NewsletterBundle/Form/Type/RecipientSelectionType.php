<?php

namespace Xsolve\NewsletterBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RecipientSelectionType extends AbstractType
{
    public function __construct($listId)
    {
        $this->listId = $listId;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $listId = $this->listId;
        $builder->add('recipients', 'entity', array(
            'label' => 'Adresy mailowe:',
            'class' => 'XsolveNewsletterBundle:Recipient',
            'property' => 'mail',
            'query_builder' => function (EntityRepository $er) use ($listId) {
                return $er->createQueryBuilder('r')
                        ->where('IDENTITY(r.list) = :listId')
                        ->setParameter('listId', $listId)
                        ->orderBy('r.mail', 'ASC');
            },
            'multiple' => true,
            'expanded' => true,

        ));
    }

    public function getName()
    {
        return "recipient_selection";
    }

}
