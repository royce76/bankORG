<?php

namespace App\Form;

use App\Entity\Operation;
use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Security;

class MouvementType extends AbstractType
{
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $formOptions = [
            'class' => Account::class,
            'invalid_message' => 'Symfony is too smart for your hacking!',
            'placeholder' => 'Choisissez',
            'choice_label' => 'account_type',
            'choice_value' => 'account_type',
            'choices' => $this->user->getAccounts(),
            // 'query_builder' => function (EntityRepository $er) {
            //       return $er->createQueryBuilder('a')
            //       ->where("a.user = :user")
            //       ->setParameter("user", $this->user);
            //   },
        ];

        $builder
            ->add('account', EntityType::class, $formOptions)
            ->add('operation_type', ChoiceType::class, [
                'invalid_message' => 'Symfony is too smart for your hacking!',
                'choices' => [
                  'Choisissez' => null,
                  'Débit' => 'Débit',
                  'Crédit' => 'Crédit',
                ],
            ])
            ->add('amount')
            ->add('comments')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
