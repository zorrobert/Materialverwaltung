<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PageController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {}

    #[Route('', name: 'app_page_index')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_page_home');
    }

    #[Route('/home', name: 'app_page_home')]
    public function home(): Response
    {
        return $this->render('page/home.html.twig', [
            #'user' => $data,
        ]);
    }

    #[Route('/material', name: 'app_page_material')]
    public function material(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $itemRepository = $this->em->getRepository(Item::class);

        $items = $itemRepository->findAll();

        return $this->render('page/material.html.twig', [
            'items' => $items,
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/calendar', name: 'app_page_calendar')]
    public function calendar(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('page/calendar.html.twig', [
            #'user' => $data,
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/profile', name: 'app_page_profile')]
    public function profile(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $this->getUser();

        if (empty($user)) {
            $data = [];
        } else {
            $data = [
                'name' => $user->getUserIdentifier(),
                'gender' => 'test',
                'firstName' => 'Vorname',
                'lastName' => 'Nachname',
                'birthday' => '2005-05-20',
                'email' => 'test@example.com',
                'phone' => 'Telefonnummer',
                'street' => 'straße',
                'streetNumber' => 'hausnummer',
                'city' => 'Telefonnummer',
                'zipcode' => 'Postleitzahl',
            ];
        }

        return $this->render('page/profile.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'user' => $user,
        ]);
    }
}
