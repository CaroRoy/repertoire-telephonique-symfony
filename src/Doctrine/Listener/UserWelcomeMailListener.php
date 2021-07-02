<?php

namespace App\Doctrine\Listener;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class UserWelcomeMailListener {

    protected $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function prePersist(User $entity) {
        $email = (new TemplatedEmail())
            ->from('welcome@monblog.fr')
            ->to($entity->getEmail())
            ->subject('Bienvenue')
            ->htmlTemplate('email/bienvenue.html.twig')
            ->context(['user' => $entity]);

            $this->mailer->send($email);
    }
}