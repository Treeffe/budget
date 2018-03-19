<?php

namespace ChicAndCheap\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        	->add('nom', 'text')
        	->add('prenom', 'text')
            ->add('adresse', 'text')
            ->add('cp', 'text')
            ->add('ville', 'text');
    }

    public function getName()
    {
        return 'user';
    }
}
