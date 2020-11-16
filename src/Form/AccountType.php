<?php

namespace App\Form;

use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('account_type', ChoiceType::class, array(
                'choices' => array(
                    'Compte courant' => 'Compte courant',
                    'PEL' => 'PEL',
                    'Compte jeune' => 'Compte jeune',
                    'Livret A' => 'Livret A',
                    'LDDS' => 'LDDS',
                ),
                'preferred_choices' => array('Compte courant'),
                'required' => true,
            ))
            ->add('balance')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
