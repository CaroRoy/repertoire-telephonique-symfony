<?php

namespace App\Controller\Contact;

use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EditContactController extends AbstractController {
    /**
     * @Route("/admin/contact/edit/{id}", name="contact_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editContactController(int $id, Request $request, ContactRepository $contactRepository, EntityManagerInterface $em) : Response {
        $contact = $contactRepository->find($id);

        if(!$contact) {
            $this->addFlash('danger', 'Ce contact n\'existe pas');
            return $this->redirectToRoute('contact_list');
        }

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Contact modifié !');
            return $this->redirectToRoute('contact_show', ['id' => $id]);
        }

        return $this->render('contact/edit.html.twig', ['form' => $form->createView()]);
    }
}