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
        //$request = Request::createFromGlobals()->getContent();
        $request = '[{"startDate":"2024-12-12T03:03","endDate":"2024-12-12T03:03"}]';
        //$request = '[{"startDate":"2024-12-12T03:03","endDate":"2024-12-12T03:03","items":"01939198-9d3a-733f-89fc-4f5e511ed54c"}]';
        if (empty($request)) {
            throw new MissingInputException("Endpoint /loan/create expects omeawf");
        }
        $loans = $serializer->deserialize($request, Loan::class . '[]', 'json');
//            AbstractNormalizer::DEFAULT_CONSTRUCTOR_ARGUMENTS => [
//                Loan::class.'[]' => ['status' => 'requested'],
//            ],
//            AbstractNormalizer::ATTRIBUTES => ['status', 'status' => ['requested']]
//        ]);

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

        return new BackendResponse('Successfully created '.sizeof($loans).' new loan(s).', 201);
    }
}
