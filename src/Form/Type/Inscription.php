<?php
/**
 * Created by PhpStorm.
 * User: BTS VM
 * Date: 15/03/2016
 * Time: 10:33
 */

namespace ChicAndCheap\Form\Type;

/**
 * Created by PhpStorm.
 * User: BTS VM
 * Date: 15/03/2016
 * Time: 10:26
 */

class Inscription extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', 'text');
        $builder->add('username', 'text');
        $builder->add('motdePasse', 'text');
        $builder->add('motDePasse', 'text');
        $builder->add('nom', 'text');
        $builder->add('prenom', 'text');
        $builder->add('adresse', 'text');
        $builder->add('codePostal', 'text');
        $builder->add('ville', 'text');
        $builder->add('username', 'text');
    }

    public function getName()
    {
        return 'Visiteur';
    }
}