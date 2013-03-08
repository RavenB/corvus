<?php

// src/Corvus/AdminBundle/Form/Type/AboutType.php
namespace Corvus\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AboutType extends AbstractType
{

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
	 	$builder->add('firstname', 'text', array(
            'label' => 'Firstname:',
            'label_attr' => array(
                'class' => 'fontBold',
            ),
        ));
        $builder->add('lastname', 'text', array(
            'label' => 'Lastname:',
        ));
        $builder->add('age', 'number', array(
            'label' => 'Age:',
        ));
        $builder->add('bio', 'textarea', array(
            'label' => 'Bio:',
        ));
        $builder->add('address', 'textarea', array(
            'label' => 'Address:',
        ));
        $builder->add('location', 'text', array(
            'label' => 'Location:',
        ));
        $builder->add('interests_hobbies', 'textarea', array(
            'label' => 'Interests/Hobbies:',
        ));
        $builder->add('email_address', 'email', array(
            'label' => 'Email Address:',
        ));
        $builder->add('twitter', 'text', array(
            'label' => 'Twitter:',
        ));
        $builder->add('facebook', 'text', array(
            'label' => 'Facebook:',
        ));
	}

	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'Corvus\AdminBundle\Entity\About',
		);
	}

	public function getName()
	{
		return 'about';
	}
}