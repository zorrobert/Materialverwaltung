<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
    public function material(): Response
    {
        $itemRepository = $this->em->getRepository(Item::class);

        $items = $itemRepository->findAll();

        return $this->render('page/material.html.twig', [
            'items' => $items
        ]);
    }

    #[Route('/calendar', name: 'app_page_calendar')]
    public function calendar(): Response
    {
        return $this->render('page/calendar.html.twig', [
            #'user' => $data,
        ]);
    }

    #[Route('/profile', name: 'app_page_profile')]
    public function profile(): Response
    {
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
            'user' => $data,
        ]);
    }
}
