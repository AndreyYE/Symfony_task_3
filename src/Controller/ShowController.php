<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Service\DateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController
{

    private $service_date;

    public function __construct(DateService $service_date)
    {

        $this->service_date = $service_date;
    }

    /**
     * @Route("/", name="show")
     */
    public function index()
    {
        return $this->render('show/index.html.twig', [
            'controller_name' => 'ShowController',
        ]);
    }
    /**
     * @Route("/order", name="order")
     */
    public function order(Request $request)
    {
        $error=[];
        $params = $request->query->all();
        $this->service_date->set_request($request);

        $orders = $this->getDoctrine()->getRepository(Order::class)->getOrdersFilterDate( $this->service_date->get_date_from(), $this->service_date->get_date_to());
        if (!$orders) {
            array_push($error, 'Нет ни одного заказа в указанный период времени');
        }
        return $this->render('show/order.html.twig', [
            'params' => $params,
            'error'=>$error,
            'orders'=>$orders,
        ]);
    }
    /**
     * @Route("/item", name="item")
     */
    public function item(Request $request)
    {
        $error=[];
        $params = $request->query->all();
        $this->service_date->set_request($request);
        $top_100_order_items = $this->getDoctrine()->getRepository(OrderItem::class)->findOneBySomeField($this->service_date->get_date_from(), $this->service_date->get_date_to());
        if (!$top_100_order_items) {
            array_push($error, 'Нет ни одного товара в указанный период времени');
        }
        return $this->render('show/item.html.twig', [
            'controller_name' => 'ShowController',
            'top_100_order_items'=>$top_100_order_items,
            'error'=>$error,
            'params'=>$params
        ]);
    }
}
