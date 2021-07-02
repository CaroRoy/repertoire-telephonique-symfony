<?php

namespace App\Controller\Contact;

use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShowContactController extends AbstractController {
    /**
     * @Route("/contact/show/{id}", name="contact_show")
     * @IsGranted("ROLE_USER")
     */
    public function contactShow(ContactRepository $contactRepository, int $id) : Response {
        $contact = $contactRepository->find($id);

        if(!$contact) {
            $this->addFlash('danger', 'Ce contact n\'existe pas');
            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/contact_show.html.twig', ['contact' => $contact]);
    }
}