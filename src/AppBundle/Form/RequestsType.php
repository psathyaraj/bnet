<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\DBAL\Types\DateTimeType;

class RequestsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('qty')
            ->add('blood_group')
            ->add('patient_name')
            ->add('within_hours')
            ->add('status')
            ->add('hospital')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Requests',
        		'csrf_protection'   => false,
        		'allow_extra_fields' => true,
        		'validation_groups' => array('Default'),
        		'cascade_validation' => true,
        		'error_bubbling' => true,
        ));
    }
}
