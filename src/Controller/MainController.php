<?php

namespace App\Controller;

use App\Entity\Account;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
          $accounts = $this->getDoctrine()->getRepository(Account::class)->getAccountLastOperation($user->getId());
          foreach ($accounts as $account) {
            $operations = $account->getOperations();
          }


          return $this->render('main/index.html.twig', [
              'controller_name' => 'MainController',
          ]);
        }

    }
}
