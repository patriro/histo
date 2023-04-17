<?php

namespace App\Service;

use App\Entity\Address;
use App\Entity\Company;
use App\Entity\Schedule as ModelSchedule;
use App\Repository\AddressRepository;
use App\Repository\CompanyRepository;
use App\Repository\LegalStatusRepository;
use App\Repository\ScheduleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class Schedule
{
    public function __construct(
        private EntityManagerInterface $em,
        private ScheduleRepository $scheduleRepository,
        private CompanyRepository $companyRepository,
        private AddressRepository $addressRepository,
        private LegalStatusRepository $legalStatusRepository,
    ) { }

    public function addSchedule($date, $company): void
    {
        $company = json_decode($company, true);
        // @TODO, Heure serveur incorrect !!
        $date = new DateTime(json_decode($date) . '+ 2 hours');
        $schedule = new ModelSchedule();
        $schedule->setData($company);
        $schedule->setDate($date);
        $schedule->setEntity(Company::class);
        $schedule->setIdObject($company['id']);

        $this->em->persist($schedule);
        $this->em->flush();
    }

    public function applySchedule(): void
    {
        foreach ($this->scheduleRepository->findAll() as $schedule) {
            $curentDate = new DateTime('now + 2 hours');

            if ($curentDate < $schedule->getDate()) {
                continue;
            }

            $company = $this->companyRepository->findOneById($schedule->getIdObject());
            $company->setName($schedule->getData()['name']);
            $company->setSiren($schedule->getData()['siren']);
            $company->setRegistrationDate(new DateTime($schedule->getData()['registrationDate']));
            $company->setCapital($schedule->getData()['capital']);

            $legalStatus = $this->legalStatusRepository->findOneById($schedule->getData()['legalStatus']['id']);
            $company->setLegalStatus($legalStatus);

            $scheduledAddresses = $schedule->getData()['addresses'];
            foreach ($scheduledAddresses as $scheduledAddress) {
                $address = null;

                if (isset($scheduledAddress['id'])) {
                    $address = $this->addressRepository->findOneById($scheduledAddress['id']);
                } else {
                    $address = new Address();
                }

                $address->setNumber($scheduledAddress['number']);
                $address->setRoadType($scheduledAddress['roadType']);
                $address->setRoadName($scheduledAddress['roadName']);
                $address->setCity($scheduledAddress['city']);
                $address->setPostCode($scheduledAddress['postCode']);
                $address->setCompany($company);
                $this->em->persist($address);
            }

            $this->em->persist($company);
            $this->em->remove($schedule);
            $this->em->flush();
        }
    }
}
