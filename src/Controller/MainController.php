<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Repository\OperationRepository;
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
}
