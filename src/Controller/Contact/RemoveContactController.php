<?php

namespace App\Controller\Contact;

use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RemoveContactController extends AbstractController {
    /**
     * @Route("/admin/contact/remove{id}", name="contact_remove")
     * @IsGranted("ROLE_ADMIN")
     */
    public function contactRemove(int $id, EntityManagerInterface $em, ContactRepository $contactRepository) : RedirectResponse {
        $contactToRemove = $contactRepository->find($id);

        if(!$contactToRemove) {
            $this->addFlash('danger', 'Ce contact n\'existe pas');
            return $this->redirectToRoute('contact_list');
        }

        $em->remove($contactToRemove);
        $em->flush();

        $this->addFlash('success', 'Contact supprimé !');

        return $this->redirectToRoute('contact_list');
    }
}