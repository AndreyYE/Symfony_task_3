<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

     /**
      * @return Order[] Returns an array of Order objects
      */

    public function getOrdersFilterDate($date_from, $date_to)
    {
        return $this->createQueryBuilder('o')
            ->addSelect("SUM(alias_order_items.product_price*alias_order_items.amount) as sum")
            ->join('o.orderItems', 'alias_order_items')
            ->andWhere('o.create_datetime >= :date_from')
            ->andWhere('o.create_datetime <= :date_to')
            ->setParameter('date_from', $date_from)
            ->setParameter('date_to', $date_to)
            ->groupBy('o.number')
            ->orderBy('o.create_datetime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }



    public function findOneBySomeField()
    {

    }

}
