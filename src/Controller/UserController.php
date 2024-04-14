<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;

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
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = ($error) ? $authenticationUtils->getLastUsername() : '';

        return $this->redirectToRoute('home', [
            'error' => (!empty($error)) ? 'failed' : '',
            'lastUsername' => $lastUsername
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Security $security): Response
    {
        $security->logout(false);
        return $this->redirectToRoute('home');
    }
}
