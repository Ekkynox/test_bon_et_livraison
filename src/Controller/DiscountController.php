<?php

namespace App\Controller;

use App\Entity\DiscountCode;
use App\Entity\User;
use App\Form\DiscountType;
use App\Service\CheckDiscountService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscountController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/discount', name: 'discount')]
    public function index(Request $request, CheckDiscountService $checkDiscountService): Response
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $discount = new DiscountCode();
        $discountForm = $this->createForm(DiscountType::class, $discount);
        $discountForm->handleRequest($request);

        if($discountForm->isSubmitted() && $discountForm->isValid()) {
            $validity = $checkDiscountService->checkDiscount($discount->getCode(), $user);
            dd($validity);
        }

        return $this->render('discount/index.html.twig', [
            'discountForm' => $discountForm->createView(),
        ]);
    }
}
