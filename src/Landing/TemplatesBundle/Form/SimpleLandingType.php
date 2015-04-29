<?php

namespace Landing\TemplatesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SimpleLandingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('templateName')
            ->add('templateTitle')
            ->add('templateH1')
            ->add('templateLead')
            ->add('templateButton')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Landing\TemplatesBundle\Entity\SimpleLanding'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'landing_templatesbundle_simplelanding';
    }
}
