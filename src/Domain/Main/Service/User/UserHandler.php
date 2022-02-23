<?php

namespace App\Domain\Main\Service\User;

use App\Domain\Main\Entity\User;
use App\Domain\Main\DTO\CreateUser;
use App\Domain\Main\Entity\Pokemon;
use App\Domain\Helper\EntityManagerInterface;

class UserHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
    }

    /**
     * Create and save user.
     */
    public function createAndSave(CreateUser $dto): User
    {
        $user = (new User())
            ->setEmail($dto->getEmail())
            ->setUsername($dto->getUserName())
            ->setPassword($dto->getPassword())
        ;
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function addPokemon(Pokemon $pokemon, User $user): void
    {
        $user->addPokemon($pokemon);
        $this->entityManager->persist($pokemon);
        $this->entityManager->flush();
    }

    public function removePokemon(Pokemon $pokemon, User $user): void
    {
        $user->removePokemon($pokemon);
        $this->entityManager->flush();
    }
}
