<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PageController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    )
    {
    }

    #[Route('/profile')]
    public function profile(): Response
    {
        $user = $this->getUser();

        if (empty($user)) {
            $data = [];
        } else {
            $data =[
                'name' => $user->getUserIdentifier(),
            ];
        }

        return $this->render('page/profile.html.twig', [
            'user' => $data,
        ]);
    }

    #[Route('/material')]
    public function material(): Response
    {
        $itemRepository = $this->em->getRepository(Item::class);

        $items = $itemRepository->findAll();

        return $this->render('page/material.html.twig', [
            'items' => $items
        ]);
    }
}
