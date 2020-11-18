<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Repository\OperationRepository;
use App\Entity\Account;
use App\Form\AccountType;
use App\Form\MouvementType;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
*
* @IsGranted("ROLE_USER")
*/

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        $operations = $this->getDoctrine()->getRepository(Operation::class)->getAccountLastOperation($user->getId());

        return $this->render('main/index.html.twig', [
            'operations' => $operations,
            'user' => $user,
        ]);
    }

    /**
     * @Route("/account/{id}", name="app_account", requirements={"id"="\d+"})
     */
    public function account(int $id): Response
    {
        $operations = $this->getDoctrine()->getRepository(Operation::class)->getAccountAndOperations($id);

        return $this->render('main/single.html.twig', [
            'operations' => $operations,
        ]);

    }


    /**
     * @Route("/account/new", name="app_account_new")
     */
    public function new_account(Request $request,  ValidatorInterface $validator): Response
    {
        $account = new Account();
        $operation = new Operation();
        $form = $this->createForm(AccountType::class,$account);
        $errors = [];
        $user = $this->getUser();

        $account->setOpeningDate($account->getOpeningDate());
        $account->setUser($user);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($account->getOpeningDate());
            $account = $form->getData();
            if(count($errors) === 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($account);

                $operation->setOperationType('Crédit');
                $operation->setDateTransaction(new \DateTime());
                $operation->setComments('Dépôt initial');
                $operation->setUser($user);
                $operation->setAccount($account);
                $operation->setAmount($account->getBalance());

                $entityManager->persist($operation);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Compte créé.'
                );

                return $this->redirectToRoute('app_home');
            }
            else {
                $this->addFlash(
                    'danger',
                    'Ce compte n\'a pu être créé !'
                );
            }
        }

        return $this->render('main/account_new.html.twig', [
            'accountForm' => $form->createView(),
            'errors' => $errors,
        ]);
    }

    /**
     * @Route("/mouvement", name="app_mouvement")
     */
     public function mouvement(Request $request, ValidatorInterface $validator): Response
     {
        $errors = [];
       // creates a operation object and initializes some data for this example
        $operation = new Operation();
        $form = $this->createForm(MouvementType::class, $operation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $operation->setUser($this->getUser());
          $operation->setDateTransaction(new \DateTime('today'));
          $errors = $validator->validate($operation);

          // $form->getData() holds the submitted values
          // but, the original `$operation` variable has also been updated
          $operation = $form->getData();

          //on récupère l'objet compte
          $account = $operation->getAccount();
          $balance = $account->getBalance();
          $amount = $operation->getAmount();

          if ($operation->getOperationType() === 'Débit') {
            $amount = (-1) * $amount;
          }
          else {
            $amount;
          }

          //on additionne et la mise à jour du solde
          $account->setBalance($balance + $amount);
          $operation->setAmount($amount);

          //Si il n'y pas d'erreurs.
          if(count($errors) === 0) {
            dump($account);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operation);
            $entityManager->persist($account);
            $entityManager->flush();
          }
          return $this->redirectToRoute('app_home');
        }

        return $this->render('main/mouvement.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
     }
}
