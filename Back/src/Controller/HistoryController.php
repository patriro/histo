<?php

namespace App\Controller;

use App\Entity\Company;
use App\Service\CompanyHistory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class HistoryController extends AbstractController
{
    public function __invoke(Company $company, SerializerInterface $serializer, CompanyHistory $companyHistory)
    {
        return new JsonResponse($serializer->serialize($companyHistory->getCompanyHistory($company), 'jsonld'), 201, [], true);
    }
}
