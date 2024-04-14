<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Cache\CacheItemPoolInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, CacheItemPoolInterface $cacheItemPool): Response
    {
        $joke = $cacheItemPool->getItem('joke')->get();

        return $this->render('home/index.html.twig', [
            'last_username' => $request->query->get('lastUsername'),
            'error' => $request->query->get('error'),
            'joke' => $joke,
        ]);
    }
}
