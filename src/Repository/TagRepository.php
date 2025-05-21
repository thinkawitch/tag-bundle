<?php

namespace Thinkawitch\TagBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Thinkawitch\TagBundle\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 *
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function searchTags(?string $search = null, ?string $category = null, int $maxResults = 10): array
    {
        $qb = $this->createQueryBuilder('t');
        $qb->select('t');

        if ($category) {
            $qb->andWhere('t.category = :category')->setParameter('category', $category);
        }

        if ($search) {
            $qb->andWhere('t.name LIKE :search')->setParameter('search', '%'.$search.'%');
        }

        if ($maxResults) {
            $qb->setMaxResults($maxResults);
        }

        return $qb->getQuery()->getResult();
    }

    public function getTagsCount(?string $category = null): int
    {
        $qb = $this->createQueryBuilder('t')->select('COUNT(t.id)');
        if ($category) {
            $qb->andWhere('t.category = :category')->setParameter('category', $category);
        }
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getTagsQueryBuilder(?string $category = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('t')->orderBy('t.name', 'ASC');
        if ($category) {
            $qb->andWhere('t.category = :category')->setParameter('category', $category);
        }
        return $qb;
    }

    public function checkUniqueName(string $name, ?int $id = null, ?string $category = null): bool
    {
        $qb = $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.name = :name')->setParameter('name', $name)
        ;
        if ($id) {
            $qb->andWhere('t.id != :id')->setParameter('id', $id);
        }
        if ($category) {
            $qb->andWhere('t.category = :category')->setParameter('category', $category);
        }
        return $qb->getQuery()->getSingleScalarResult() < 1;
    }
}