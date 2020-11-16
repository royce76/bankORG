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

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        else {
          $operations = $this->getDoctrine()->getRepository(Operation::class)->getAccountLastOperation($user->getId());
 
          return $this->render('main/index.html.twig', [
              'operations' => $operations,
          ]);
        }

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
        $errors = null;
        $user = $this->getUser();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $account->setOpeningDate(new \DateTime());
            $account->setUser($user);
            
            $errors = $validator->validate($account);
            if(count($errors) === 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($account);

                $operation->setOperationType('Crédit');
                $operation->setDateTransaction(new \DateTime());
                $operation->setComments('Dépôt initial');
                $operation->setUser($user);
                $operation->setAccount($account);
                $operation->setAmount($account->getBalance());
    
                $entityManager = $this->getDoctrine()->getManager();
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
                    'Cet compte n\'a pu être créé !'
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
        $errors = null;
       // creates a task object and initializes some data for this example
        $operation = new Operation();
        $form = $this->createForm(MouvementType::class, $operation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
          $operation->setUser($this->getUser());
          $operation->setDateTransaction(new \DateTime('now'));
          $errors = $validator->validate($operation);

          if(count($errors) === 0) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $operation = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operation);
            $entityManager->flush();
          }

          return $this->redirectToRoute('app_home');
        }

        return $this->render('main/mouvement.html.twig', [
            'form' => $form->createView(),
        ]);
     }
}
