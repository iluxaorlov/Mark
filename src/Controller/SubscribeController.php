<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeController extends AbstractController
{
    /**
     * @Route("/{nickname}/subscribe", name="subscribe")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function subscribe(User $user, Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser->getSubscriptions()->contains($user) === false) {
            $currentUser->getSubscriptions()->add($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentUser);
            $entityManager->flush();
        }

        return $this->render('user/action.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{nickname}/unsubscribe", name="unsubscribe")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function unsubscribe(User $user, Request $request): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser->getSubscriptions()->contains($user) === true) {
            $currentUser->getSubscriptions()->removeElement($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentUser);
            $entityManager->flush();
        }

        return $this->render('user/action.html.twig', [
            'user' => $user,
        ]);
    }
}