<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Item;
use App\Exception\InvalidInputException;
use App\Exception\MissingInputException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ItemController extends AbstractController
{
    #[Route('/api/item/create', name: 'app_item_create')]
    public function create(
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): BackendResponse
    {
        $request = Request::createFromGlobals()->getContent();
        if (empty($request)) {
            throw new MissingInputException("API Endpoint /item/create expects an array of items, none provided.");
        }

        # this is for authentication, implement later
//        if (!$this->isGranted('create')) {
//            throw new MissingInputException("not logged in");
//        }

        $newItems = $serializer->deserialize($request, Item::class . '[]', 'json');

        Item::createItems($newItems, $em, $validator);
        return new BackendResponse('Successfully created '.sizeof($newItems).' new item(s).', 201);
    }

    #[Route('/api/item/list', name: 'app_api_item_list')]
    public function list(EntityManagerInterface $em, SerializerInterface $serializer): BackendResponse
    {
        $items = $em->getRepository(Item::class)->findAll();

        $list = $serializer->normalize($items);

        return new BackendResponse(NULL, 200, $list);
    }

    #[Route('/api/item/delete', name: 'app_item_delete')]
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

    #[Route('/api/item/edit', name: 'app_item_edit')]
    public function edit(EntityManagerInterface $em, ValidatorInterface $validator): BackendResponse
    {
        $request = Request::createFromGlobals()->getContent();
        if (empty($request)) {
            throw new MissingInputException("Endpoint /item/edit expects an array of items to modify, none provided.");
        }

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
