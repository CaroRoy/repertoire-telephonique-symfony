<?php

namespace App\Controller\Contact;

use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateContactController extends AbstractController {
    /**
     * @Route("/admin/contact/create", name="contact_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(Request $request, EntityManagerInterface $em): Response {
        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $em->persist($contact);
            $em->flush();

            $id = $contact->getId();

            $this->addFlash('success', 'Contact ajouté !');
            return $this->redirectToRoute('contact_show', ['id' => $id]);
        }
        return $this->render('contact/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
