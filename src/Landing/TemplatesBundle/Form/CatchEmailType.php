<?php

namespace Landing\TemplatesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CatchEmailType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emails', 'email', array(
                'label' => false,
                'attr' => array('class' => 'form form-control', 'style' => 'width:340px;text-align:center;margin:0 auto;'),
            ))
            ->add('submit', 'submit', array(
                'attr' => array('class' => 'btn btn-lg btn-primary'),
            ));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Landing\TemplatesBundle\Entity\CatchEmail'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'landing_templatesbundle_catchemail';
    }
}
