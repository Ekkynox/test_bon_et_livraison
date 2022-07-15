<?php

namespace App\Controller;

use App\DataTransfertObjects\ReservationRequest;
use App\Service\ReservationService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/*
Exemple de requête :
{
    "timeslot": "2022-07-18 19:00:00",
    "orderId": 2
}
*/
class ReservationController extends AbstractController
{
    #[Route('/reservation/new', name: 'reservation')]
    public function index(ReservationService $resService, Request $request, SerializerInterface $serializer): Response
    {
        /**
         * @var ReservationRequest $reservation
         */
        $reservation = $serializer->deserialize($request->getContent(), ReservationRequest::class, 'json');

        $response = $resService->reserveTimeSlot($reservation->getTimeslot(), $reservation->getOrderId());

        return new JsonResponse($response['message'], $response['code']);
        
    }
}
