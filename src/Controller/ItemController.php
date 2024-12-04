<?php

namespace App\Controller;

use App\Entity\Item;
use App\Exception\MissingInputException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ItemController extends AbstractController
{
    #[Route('/item/create', name: 'app_item_create')]
    public function create(
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): BackendResponse
    {
        $request = Request::createFromGlobals()->getContent();
        if (empty($request)) {
            throw new MissingInputException("Endpoint /item/create expects an array of items, none provided.");
        }
        $newItems = Item::fromJsonString($request, $serializer);
        Item::createItems($newItems, $em, $validator);
        return new BackendResponse('Successfully created '.sizeof($newItems).' new item(s).', 201);
    }

    #[Route('/item/list')]
    public function list(EntityManagerInterface $em, SerializerInterface $serializer): BackendResponse
    {
        $items = $em->getRepository(Item::class)->findAll();

        $list = $serializer->normalize($items);

        return new BackendResponse(NULL, 200, $list);
    }
}
