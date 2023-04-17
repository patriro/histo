<?php

namespace App\Controller;

use App\Service\Schedule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ScheduleController extends AbstractController
{
    public function __construct(private Schedule $schedule) {}

    #[Route('/schedule', name: 'schedule')]
    public function schedule(Request $request): JsonResponse
    {
        $dateScheduled = $request->get('schedule');
        $data = $request->get('company');

        $this->schedule->addSchedule($dateScheduled, $data);

        return $this->json(['success' => true]);
    }
}
