<?php

namespace Xsolve\NewsletterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RecipientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('mail', 'text', array(
            'label' => 'Adres e-mail:',
            'required' => FALSE
        ));
    }

    public function getName()
    {
        return 'recipient';
    }

}
