<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Exception\InvalidInputException;
use App\Exception\MissingInputException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoanController extends AbstractController
{
    #[Route('/loan/create', name: 'app_loan_create')]
    public function create(
        EntityManagerInterface $em,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): BackendResponse
    {
        $request = Request::createFromGlobals()->getContent();
        //$request = '[{"startDate":"2025-01-16T03:03","endDate":"2025-01-30T01:01","items":[]}]';
        if (empty($request)) {
            throw new MissingInputException("Endpoint /loan/create expects");
        }

        $loans = $serializer->deserialize($request, Loan::class . '[]', 'json');

        //$bide = $serializer->serialize($loans, 'json');

        //return new BackendResponse($bide, 201);

        foreach ($loans as $loan) {
            $loan->setStatus('requested');
        }

        $errors = $validator->validate($loans);
        if ($errors->count() > 0) {
            throw new InvalidInputException('Error creating new Loans: '.$errors[0]->getMessage());
        }
        foreach ($loans as $loan) {
            $em->persist($loan);
        }
        $em->flush();

        return new BackendResponse($request.'Successfully created '.sizeof($loans).' new loan(s).', 201);
    }

    #[Route('/loan/list', name: 'app_loan_list')]
    public function list(EntityManagerInterface $em, SerializerInterface $serializer): BackendResponse
    {
        $loans = $em->getRepository(Loan::class)->findAll();

        $list = $serializer->normalize($loans);

        return new BackendResponse(NULL, 200, $list);
    }
}
