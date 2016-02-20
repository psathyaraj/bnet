<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UsersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('dob', DateType::class,array('widget' => 'single_text','format' => 'yyyy-MM-dd',))
            ->add('gender')
            ->add('phno')
            ->add('email')
            ->add('device_token')
            ->add('bloodGroup')
            ->add('location_name')
            ->add('latitude')
            ->add('longitude')
            ->add('blood_date', DateType::class,array('widget' => 'single_text','format' => 'yyyy-MM-dd',))
            ->add('platelates_date', DateType::class,array('widget' => 'single_text','format' => 'yyyy-MM-dd',))
            ->add('plasma_date', DateType::class,array('widget' => 'single_text','format' => 'yyyy-MM-dd',))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Users',
        		'csrf_protection'   => false,
        		'allow_extra_fields' => true,
        		'validation_groups' => array('Default'),
        		'cascade_validation' => true,
        		'error_bubbling' => true,
        ));
    }
}
