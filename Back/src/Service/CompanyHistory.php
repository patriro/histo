<?php

namespace App\Service;

use App\Entity\Company;
use App\Repository\LegalStatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Gedmo\Loggable\Entity\LogEntry;

class CompanyHistory
{
    public function __construct(private EntityManagerInterface $em, private LegalStatusRepository $legalStatusRepository) {
    }

    public function getCompanyHistory(Company $company)
    {
        $gedmoRepo = $this->em->getRepository(LogEntry::class);

        $logEntries = $gedmoRepo->getLogEntries($company);
        foreach ($logEntries as $logEntry) {
            if (!isset($logEntry->getData()['legalStatus'])) {
                continue;
            }

            $idOfLegalStatus = $logEntry->getData()['legalStatus']['id'];
            $legalStatus = $this->legalStatusRepository->findOneById($idOfLegalStatus);

            $logEntryDatas = [
                'legalStatus' => [
                    'id' => $idOfLegalStatus,
                    'label' => $legalStatus->getLabel(),
                ]
            ];

            $logEntry->setData(array_merge($logEntry->getData(), $logEntryDatas));
        }

        return $logEntries;
    }
}
