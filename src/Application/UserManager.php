<?php

namespace App\Application;

use App\Domain\Main\Entity\User;
use App\Application\Mailer\Mailer;
use App\Domain\Main\DTO\CreateUser;
use App\Domain\Main\Entity\Pokemon;
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

    public function addPokemon(Pokemon $pokemon, User $user): void
    {
        $this->handler->addPokemon($pokemon, $user);
    }

    public function removePokemon(Pokemon $pokemon, User $user): void
    {
        $this->handler->removePokemon($pokemon, $user);
    }
}
