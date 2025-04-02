<?php

namespace App\Serializer\Normalizer;

use App\Entity\Loan;
use App\Entity\Item;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LoanNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,

        private EntityManagerInterface $em,
    ) {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        //$data = $this->normalizer->normalize($object, $format, $context);

        // TODO: add, edit, or delete some data
        $items = [];
        foreach ($object->getItems() as $item) {
            $items[] = $item->getId();
        }
        $data = [
            "id" => $object->getId(),
            "startDate" => $object->getStartDate(),
            "endDate" => $object->getEndDate(),
            "items" => $items,
        ];

        return $data;
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $object = new Loan();
        //$object->setStartDate($data["startDate"]);
        //$object->setEndDate($data["endDate"]);

        $itemRepository = $this->em->getRepository(Item::class);

        foreach ($data["items"] as $item) {
            //$object->addItem();
            //$bide = $itemRepository->findBy(['id' => $item]);
            $bide = $itemRepository->findOneBy(['id' => $item]);
            $object->addItem($bide);
        }

        $object->setStartDate(new DateTime($data['startDate']));
        $object->setEndDate(new DateTime($data['endDate']));

        //$object = $this->normalizer->denormalize($data, $format);

        return $object;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Loan;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return true;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Loan::class => true];
    }
}
