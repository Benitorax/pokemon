<?php

namespace App\Domain\Main\Service\User;

use App\Domain\Main\Entity\User;
use App\Domain\Main\DTO\CreateUser;
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
}
