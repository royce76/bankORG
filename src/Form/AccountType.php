<?php

namespace App\Form;

use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Security;

class AccountType extends AbstractType
{
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $available_account = $this->getAvailableAccountTypes();

        $builder
            ->add('account_type', ChoiceType::class, array(
                'choices' => $available_account,
                'choice_label' => function ($value) {
                    return $value;
                    },
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

    private function getAvailableAccountTypes(): Array {
        $bank_accounts = ['Compte courant', 'PEL', 'Compte jeune', 'Livret A', 'LDDS'];
        $user_accounts = $this->user->getAccounts();
        $user_accounts_types = [];
        foreach($user_accounts as $user_account) {
                array_push($user_accounts_types, $user_account->getAccountType());
        }
        $available_account = array_diff($bank_accounts, $user_accounts_types);
        return $available_account;
    }
}
