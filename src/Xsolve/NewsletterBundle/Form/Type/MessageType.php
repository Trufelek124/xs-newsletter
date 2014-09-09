<?php

namespace Xsolve\NewsletterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fromName', 'text', array(
            'label' => 'Nazwa nadawcy:',
            'required' => FALSE
        ));
        $builder->add('title', 'text', array(
            'label' => 'Tytuł:',
            'required' => FALSE
        ));
        $builder->add('content', 'textarea', array(
            'label' => 'Treść:',
            'required' => FALSE
        ));
    }

    public function getName()
    {
        return 'message';
    }

}
