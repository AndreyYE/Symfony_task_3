<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\AST\Join;

/**
 * @method OrderItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderItem[]    findAll()
 * @method OrderItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }

     /**
      * @return OrderItem[] Returns an array of OrderItem objects
      */

    public function findByExampleField()
    {
        return $this->createQueryBuilder('oi')
            ->leftJoin('oi.order_custom', 'alias_order_item')
            ->groupBy('oi.product_name')
            ->orderBy('SUM(oi.product_price*oi.amount)', 'DESC' )
            ->setMaxResults(100)
            ->getQuery()
            ->execute();
    }



    public function findOneBySomeField($date_from, $date_to)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '

      SELECT `product_name`,`order_customs`, SUM(amount*product_price) as sum,
        SUM(amount) as quantity, orders.create_datetime as date
        FROM `order_items` as oi
        JOIN orders ON orders.number = oi.order_customs
        WHERE EXISTS (
            SELECT *
            FROM (
                SELECT *
                FROM order_items o_i
                JOIN orders ON orders.number = o_i.order_customs
                WHERE orders.create_datetime >= :date_from AND orders.create_datetime <= :date_to
                GROUP BY `product_name`
                ORDER BY SUM(`amount`) DESC
                LIMIT 100
            ) t
        WHERE t.product_name=oi.product_name
        )
        GROUP BY `product_name`,`order_customs`


        
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['date_from' => $date_from, 'date_to' => $date_to]);

        return $stmt->fetchAll();
    }

}
