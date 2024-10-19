<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Exception\FileUploadException;
use App\Service\FileUploader;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/list', name: 'app_article_list', methods: ['GET'])]
    public function list(Request $request, ArticleRepository $articlesRepository): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $articlesRepository->getArticlePaginator($offset);

        return $this->render('article/list.html.twig', [
            'articles' => $paginator,
            'offset' => $offset,
            'previous' => $offset - ArticleRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + ArticleRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/show/{id<\d+>}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $error = false;
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            try {
                $imageFilename = $fileUploader->upload($imageFile);
                $article->setImage($imageFilename);
            } catch (FileUploadException $e) {
                $form->get('image')->addError(new FormError($e->getMessage()));
                $error = true;
            }

            if (!$error) {
                $entityManager->persist($article);//obligatoire lors d'une création
                $entityManager->flush();
                return $this->redirectToRoute('app_article_show', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    
    #[Route('/edit/{id<\d+>}', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $error = false;
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                try {
                    $fileUploader->remove($article->getImage());
                    $imageFilename = $fileUploader->upload($imageFile);
                    $article->setImage($imageFilename);
                } catch (FileUploadException | FileException $e) {
                    $form->get('image')->addError(new FormError($e->getMessage()));
                    $error = true;
                }
            }

            if (!$error) {
                $entityManager->flush();
                return $this->redirectToRoute('app_article_show', ['id' => $article->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id<\d+>}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));

        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->getPayload()->get('_token'))) {
            try {
                $fileUploader->remove($article->getImage());
            } catch (FileException $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('app_article_list', ['offset' => $offset], Response::HTTP_SEE_OTHER);
            }
            
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_list', [], Response::HTTP_SEE_OTHER);
    }
}
