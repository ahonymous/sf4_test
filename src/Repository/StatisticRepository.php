<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Statistic;
use App\Filter\StatisticFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Statistic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statistic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statistic[]    findAll()
 * @method Statistic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatisticRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Statistic::class);
    }

    /**
     * @param StatisticFilter $filter
     *
     * @return Statistic[]
     */
    public function findAllByFilter(StatisticFilter $filter): array
    {
        $qb = $this->createQueryBuilder('s');

        if ($filter->getCurrencyCode()) {
            $qb
                ->join('s.currencyTo', 'c')
                ->andWhere('LOWER(c.code) = LOWER(:code)')
                ->setParameter('code', $filter->getCurrencyCode());
        }

        if ($filter->getTimeFrom()) {
            $qb
                ->andWhere('s.time >= :timeFrom')
                ->setParameter('timeFrom', $filter->getTimeFrom());
        }

        if ($filter->getTimeTo()) {
            $qb
                ->andWhere('s.time <= :timeTo')
                ->setParameter('timeTo', $filter->getTimeTo());
        }

        return $qb
            ->addOrderBy('s.time', Criteria::ASC)
            ->getQuery()
            ->getResult();
    }
}
