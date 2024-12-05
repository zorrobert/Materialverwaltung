<?php

namespace App\Controller;

use App\Entity\Item;
use App\Exception\InvalidInputException;
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

    #[Route('/item/delete')]
    public function delete(EntityManagerInterface $em): BackendResponse
    {
        $request = Request::createFromGlobals()->getContent();
        $idList = array_filter(json_decode($request)); # filter out NULL values and empty strings
        if (empty($idList)) {
            throw new MissingInputException("Endpoint /item/delete expects an array of Item IDs to delete, none provided.");
        }
        $itemRepository = $em->getRepository(Item::class);

        foreach ($idList as $id)
        {
            $item = $itemRepository->find($id);
            if (empty($item)) {
                throw new MissingInputException("Could not delete items: Item ".$id.' was not found.');
            }
            $em->remove($item);
        }
        $em->flush();

        return new BackendResponse("Successfully deleted ".sizeof($idList).' items.', 200);
    }

    #[Route('/item/edit')]
    public function edit(EntityManagerInterface $em, ValidatorInterface $validator): BackendResponse
    {
        $request = Request::createFromGlobals()->getContent();
        if (empty($request)) {
            throw new MissingInputException("Endpoint /item/edit expects an array of items to modify, none provided.");
        }
        //$request = '{"0193919d-2921-7508-8da8-de06754b76b6":{"name":"newName","description":"newDescription","inventoryId":"newinventoryId"},"0193922d-f9d2-7f7b-839e-a8fe56bb8df3":{"name":"newName","description":"newDescription","inventoryId":"uniqueinventoryId"}}';
        $items = json_decode($request, true);

        $itemRepository = $em->getRepository(Item::class);

        $updatedItems = [];
        foreach ($items as $id => $item) {
            $updated = $itemRepository->find($id);
            foreach ($item as $property => $value) {
                switch ($property) {
                    case 'name': $updated->setName($value); break;
                    case 'description': $updated->setDescription($value); Break;
                    case 'inventoryId': $updated->setInventoryId($value); Break;
                    default: throw new InvalidInputException('Error modifying items: Property "'.$property.'" does not exist.');
                }
            }
            $updatedItems[] = $updated;
        }
        Item::editItems($updatedItems, $em, $validator);

        return new BackendResponse($request, 200);
    }
}
