<?php

namespace App\Entity;

use App\Exception\InvalidInputException;
use App\Repository\ItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $inventoryId = null;

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addConstraint(new UniqueEntity([
            'fields' => [ 'inventoryId' ],
            'message' => 'The Inventory ID must be unique across all items.',
            'ignoreNull' => [ 'inventoryId' ],
        ]));
    }

    public static function fromJsonString(string $jsonString, SerializerInterface $serializer): array
    {
        return $serializer->deserialize($jsonString, Item::class . '[]', 'json');
    }

    public static function createItems(array $items, EntityManagerInterface $em, ValidatorInterface $validator): void
    {
        $errors = $validator->validate($items);
        if ($errors->count() > 0) {
            throw new InvalidInputException('Error creating new Items: '.$errors[0]->getMessage());
        }
        foreach ($items as $item) {
            $em->persist($item);
        }
        $em->flush();
    }

    public static function editItems(array $items, EntityManagerInterface $em, ValidatorInterface $validator): void
    {
        $errors = $validator->validate($items);
        if ($errors->count() > 0) {
            throw new InvalidInputException('Error modifying Items: '.$errors[0]->getMessage());
        }
        foreach ($items as $item) {
            $em->persist($item);
        }
        $em->flush();
    }

    public function getId(array $items, EntityManagerInterface $em, ValidatorInterface $validator): ?Uuid
    {

        $uuids = [];

        foreach ($items as $item) {
            if ($item instanceof Item) {
                $uuid = $item->getId($items, $em, $validator);  
            }
            if($uuid){
                $uuids = $uuid; 
            }
        }

        return $uuids;
    }

    public function getName(array $items): ?array
    {
        $names = [];

        foreach($items as $item){
            if($item instanceof Item){
                $name = $item->getName();
                if($name){
                    $names[] = $name;
                }
            }
        }
     
        return $name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getInventoryId(): ?string
    {
        return $this->inventoryId;
    }

    public function setInventoryId(?string $inventoryId): static
    {
        $this->inventoryId = $inventoryId;

        return $this;
    }
}
