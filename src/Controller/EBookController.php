<?php

namespace App\Controller;

use App\Entity\EBook;
use App\Form\EBookType;
use App\Repository\EBookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ebook")
 */
class EBookController extends AbstractController
{
    /**
     * @Route("/", name="e_book_index", methods={"GET"})
     */
    public function index(EBookRepository $eBookRepository): Response
    {
        return $this->render('e_book/index.html.twig', [
            'e_books' => $eBookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="e_book_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $eBook = new EBook();
        $form = $this->createForm(EBookType::class, $eBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eBook);
            $entityManager->flush();

            return $this->redirectToRoute('e_book_index');
        }

        return $this->render('e_book/new.html.twig', [
            'e_book' => $eBook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="e_book_show", methods={"GET"})
     */
    public function show(EBook $eBook): Response
    {
        return $this->render('e_book/show.html.twig', [
            'e_book' => $eBook,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="e_book_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EBook $eBook): Response
    {
        $form = $this->createForm(EBookType::class, $eBook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('e_book_index');
        }

        return $this->render('e_book/edit.html.twig', [
            'e_book' => $eBook,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="e_book_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EBook $eBook): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eBook->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eBook);
            $entityManager->flush();
        }

        return $this->redirectToRoute('e_book_index');
    }
}
