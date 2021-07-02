<?php

namespace App\Controller\Contact;

use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListContactController extends AbstractController {
    /**
     * @Route("/contact/list", name="contact_list")
     * @IsGranted("ROLE_USER")
     */
    public function contactList(ContactRepository $contactRepository) : Response {
        $contacts = $contactRepository->findAll();
        return $this->render('contact/contact_list.html.twig', ['contacts' => $contacts]);
    }
}