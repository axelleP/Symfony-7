<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    public function __construct(
        private LocaleSwitcher $localeSwitcher,
    ) {
    }

    #[Route('/change-locale/{locale}', name: 'locale.change', requirements: ['locale' => '[a-z]{2}'])]
    public function changeLocale(Request $request, string $locale): Response
    {
        $request->getSession()->set('_locale', $locale);
        return $this->redirectToRoute('home');
    }
}
