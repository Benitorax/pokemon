<?php

namespace App\Domain\Helper;

/**
 * The PHPDoc content is from Doctrine/ORM/EntityRepository class.
 *
 * @method Battle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Battle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Battle[]    findAll()
 * @method Battle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @template T
 */
interface EntityRepositoryInterface
{
    /**
     * Finds an entity by its primary key / identifier.
     *
     * @param mixed    $id          The identifier.
     * @param int|null $lockMode    One of the \Doctrine\DBAL\LockMode::* constants
     *                              or NULL if no specific lock mode should be used
     *                              during the search.
     * @param int|null $lockVersion The lock version.
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     * @psalm-return ?T
     */
    public function find($id, $lockMode = null, $lockVersion = null);

    /**
     * Finds all entities in the repository.
     *
     * @psalm-return list<T> The entities.
     */
    public function findAll();

    /**
     * Finds entities by a set of criteria.
     *
     * @param int|null $limit
     * @param int|null $offset
     * @psalm-param array<string, mixed> $criteria
     * @psalm-param array<string, string>|null $orderBy
     *
     * @return object[] The objects.
     * @psalm-return list<T>
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    /**
     * Finds a single entity by a set of criteria.
     *
     * @psalm-param array<string, mixed> $criteria
     * @psalm-param array<string, string>|null $orderBy
     *
     * @return object|null The entity instance or NULL if the entity can not be found.
     * @psalm-return ?T
     */
    public function findOneBy(array $criteria, ?array $orderBy = null);

    /**
     * Counts entities by a set of criteria.
     *
     * @psalm-param array<string, mixed> $criteria
     *
     * @return int The cardinality of the objects that match the given criteria.
     *
     * @todo Add this method to `ObjectRepository` interface in the next major release
     */
    public function count(array $criteria);
}
