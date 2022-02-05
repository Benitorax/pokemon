<?php

namespace App\Application\Mailer;

use App\Domain\Main\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send an email to confirm user email.
     */
    public function sendSubscription(User $user): void
    {
        $email = (new Email())
            ->from('fabien@example.com')
            ->to(new Address('ryan@example.com'))
            ->subject('Thanks for signing up!')
        ;
        $this->mailer->send($email);
    }
}
