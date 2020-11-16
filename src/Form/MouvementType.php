<?php

namespace App\Form;

use App\Entity\Operation;
use App\Repository\OperationRepository;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\Account;
use App\Repository\AccountRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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
              'choice_label' => 'account_type',
              'choice_value' => 'account_type',
              'choices' => $this->user->getAccounts(),
              // 'query_builder' => function (EntityRepository $er) {
              //       return $er->createQueryBuilder('a')
              //       ->where("a.user = :user")
              //       ->setParameter("user", $this->user);
              //   },
              'expanded' => false,
              'multiple' => false,
          ];


        $builder
            ->add('operation_type')
            ->add('amount')
            ->add('comments')
            ->add('submit', SubmitType::class)
            ->add('account', EntityType::class, $formOptions);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operation::class,
        ]);
    }
}
