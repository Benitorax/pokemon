<?php

namespace App\Application;

use App\Application\Mailer\Mailer;
use App\Domain\Main\DTO\CreateUser;
use App\Domain\Main\Service\User\UserHandler;

class UserManager
{
    private UserHandler $handler;

    private Mailer $mailer;

    public function __construct(
        UserHandler $handler,
        Mailer $mailer
    ) {
        $this->handler = $handler;
        $this->mailer = $mailer;
    }

    public function subscribeUser(CreateUser $dto): void
    {
        $user = $this->handler->createAndSave($dto);
        $this->mailer->sendSubscription($user);
    }
}
