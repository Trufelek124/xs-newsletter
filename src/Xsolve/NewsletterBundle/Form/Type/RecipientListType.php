<?php

namespace Xsolve\NewsletterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RecipientListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'Nazwa:',
            'required' => FALSE
        ));
    }

    public function getName()
    {
        return 'recipient_list';
    }

}
