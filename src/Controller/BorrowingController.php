<?php

namespace App\Controller;

use App\Entity\Borrowing;
use App\Form\BorrowingType;
use App\Repository\BorrowingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/borrowing")
 */
class BorrowingController extends AbstractController
{
    /**
     * @Route("/", name="borrowing_index", methods={"GET"})
     */
    public function index(BorrowingRepository $borrowingRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $borrowings = $paginator->paginate(
            $borrowingRepository->findAll(), // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            25 // Nombre de résultats par page
        );
        return $this->render('borrowing/index.html.twig', [
            'borrowings' => $borrowings,
        ]);
    }

    /**
     * @Route("/retard", name="borrowing_retard", methods={"GET"})
     */
    public function borrowedNotDelivered()
    {
        $users = $this->getDoctrine()->getRepository(Borrowing::class)->borrowedNotDelivered();
        $usersRetard = [];
        // $relaunchService->relaunchSystem();

        function NbJours($debut, $fin)
        {
            $diff = $debut->diff($fin)->format("%a");
            return $diff;
        }

        foreach ($users as $user) {
            $nbJours = NbJours($user['expectedReturnDate'], new \DateTime('now'));
            $user["days"] = $nbJours;
            $usersRetard[] = $user;
        }

        return $this->render('borrowing/borrowedNotDelivered.html.twig', [
            'users' => $usersRetard,
        ]);
    }

    /**
     * @Route("/new", name="borrowing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $borrowing = new Borrowing();
        $form = $this->createForm(BorrowingType::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($borrowing);
            $entityManager->flush();

            return $this->redirectToRoute('borrowing_index');
        }

        return $this->render('borrowing/new.html.twig', [
            'borrowing' => $borrowing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="borrowing_show", methods={"GET"})
     */
    public function show(Borrowing $borrowing): Response
    {
        return $this->render('borrowing/show.html.twig', [
            'borrowing' => $borrowing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="borrowing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Borrowing $borrowing): Response
    {
        $form = $this->createForm(BorrowingType::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('borrowing_index');
        }

        return $this->render('borrowing/edit.html.twig', [
            'borrowing' => $borrowing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="borrowing_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Borrowing $borrowing): Response
    {
        if ($this->isCsrfTokenValid('delete' . $borrowing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($borrowing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('borrowing_index');
    }
}
