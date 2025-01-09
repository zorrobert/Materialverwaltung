<?php

namespace App\Serializer\Normalizer;

use App\Entity\Item;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ItemNormalizer implements NormalizerInterface //, DenormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
    ) {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        // replace array of loan entities with array of uuids
        $loans = [];
        foreach ($object->getLoans() as $loan) {
            $loans[] = $loan->getId();
        }
        $data["loans"] = $loans;

        return $data;
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Item;
    }

//    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
//    {
//        return true;
//    }

    public function getSupportedTypes(?string $format): array
    {
        return [Item::class => true];
    }
}
