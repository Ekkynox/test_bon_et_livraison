<?php

namespace App\Controller;

use App\DataTransfertObjects\CheckDiscountRequest;
use App\Service\CheckDiscountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/*
Exemple de requête :
{
    "code": "2022-07-18 19:00:00",
    "userCity": 2",
    "userBirthDate": "1998-10-31"
}
*/
class DiscountController extends AbstractController
{
    #[Route('/discount/check', name: 'discount')]
    public function checkDiscount(Request $request, CheckDiscountService $checkDiscountService, SerializerInterface $serializer): Response
    {
        /**
         * @var CheckDiscountRequest $checkDiscountRequest
         */
        $checkDiscountRequest = $serializer->deserialize($request->getContent(), CheckDiscountRequest::class, 'json');

        $validity = $checkDiscountService->checkDiscount($checkDiscountRequest->getCode(), $checkDiscountRequest->getUserCity(), $checkDiscountRequest->getUserBirthDate());

        return new JsonResponse($validity, 200);
    }
}
