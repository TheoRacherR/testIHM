<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\AddArticleFormType;
use App\Form\EditArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BlogController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->redirectToRoute('list_article');
    }

    #[Route('/add_article', name: 'add_article')]
    public function add_article(ManagerRegistry $doctrine, Request $request)
    {
        $article = new Article();
        $formArticle = $this->createForm(AddArticleFormType::class, $article);
        try {
            $formArticle->handleRequest($request);
            if ($formArticle->isSubmitted() && $formArticle->isValid()) {
                $entityManager = $doctrine->getManager();
                $addArticle = $formArticle->getData();
                $addArticle->setCreatedAt(new \DateTimeImmutable())
                           ->setUpdatedAt(new \DateTimeImmutable());
                $entityManager->persist($addArticle);
                $entityManager->flush();

                $this->addFlash('success', 'L\'article a été ajouté avec succès !');
                return $this->redirectToRoute('article_page', ['id' => $article->getId()]);
            }
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
            $this->redirectToRoute('list_article');
        }
        return $this->render('blog/add_article.html.twig', [
            'formArticle' => $formArticle->createView()
        ]);
    }

    #[Route('/list_articles', name: 'list_article')]
    public function list_articles(ManagerRegistry $doctrine, Request $request)
    {

        $articles = $doctrine->getRepository(Article::class)->findAll();
        return $this->render('blog/list_articles.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/edit_article/{id}', name: 'edit_article')]
    public function edit_article(int $id, ManagerRegistry $doctrine, Request $request)
    {

        $article = $doctrine->getRepository(Article::class)->find($id);
        if ($article === false) {
            throw new \Exception('Le article demandé est introuvable');
        }
        $formEditArticle = $this->createForm(EditArticleFormType::class, $article);

        try {
            $formEditArticle->handleRequest($request);
            if ($formEditArticle->isSubmitted() && $formEditArticle->isValid()) {
                $entityManager = $doctrine->getManager();
                $editArticle = $formEditArticle->getData();
                $article = $editArticle; //a faire
                $article->setUpdatedAt(new \DateTimeImmutable());
                $entityManager->persist($article);
                $entityManager->flush();

                $this->addFlash('success', 'Le article a été modifié avec succès !');
            }
        } catch (\Exception $e) {

            $this->addFlash('error', $e->getMessage());
            $this->redirectToRoute('root');
        }
        return $this->render('blog/edit_article.html.twig', [
            'article' => $article,
            'formEditArticle' => $formEditArticle->createView(),
        ]);
    }

    #[Route('/delete_article/{id}', name: 'delete_article')]
    public function delete_article(int $id, ManagerRegistry $doctrine, EntityManagerInterface $manager)
    {
        try {
            $article = $doctrine->getRepository(Article::class)->find($id);
            if ($article === false) {
                throw new \Exception('L\'article demandé est introuvable');
            }
            $manager->remove($article);
            $manager->flush();
            $this->addFlash('success', 'L\'article a été supprimé avec succès');
        } catch (\Exception $e) {
            $this->addFlash('error', $e->getMessage());
        }
        return $this->redirectToRoute('list_article');
    }


    #[Route('/article_page/{id}', name: 'article_page')]
    public function article_page(int $id, ManagerRegistry $doctrine)
    {

        $article = $doctrine->getRepository(Article::class)->find($id);
        if ($article === false) {
            throw new \Exception('Le article demandé est introuvable');
        }
        return $this->render('blog/article.html.twig', [
            'article' => $article
        ]);
    }


}
