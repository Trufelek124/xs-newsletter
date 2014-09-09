<?php

namespace Xsolve\NewsletterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DispatchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('message', 'entity', array(
            'label' => 'Wiadomość:',
            'required' => FALSE,
            'class' => 'XsolveNewsletterBundle:Message',
            'property' => 'title',
        ));
        $builder->add('list', 'entity', array(
            'label' => 'Lista odbiorców:',
            'required' => FALSE,
            'class' => 'XsolveNewsletterBundle:RecipientList',
            'property' => 'name'
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Xsolve\NewsletterBundle\Entity\Dispatch'
        ));
    }

    public function getName()
    {
        return 'dispatch';
    }

}
