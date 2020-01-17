<?php

namespace Command;
use Doctrine\ORM\EntityManager;
use Entity\Order;
use Entity\OrderItem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\Tools\Setup;

/**
* OrdersCommand
*/
class OrdersCommand extends Command
{
    /**
     * Configuration of command
     */
    protected function configure()
    {
        $this
            ->setName("orders")
            ->setDescription("Command orders")
            ->addArgument('order_quantity', InputArgument::REQUIRED, 'How many order do you want generate?')
        ;
    }

    /**
     * Execute method of command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //количество строк в таблице order_items
        $last_order_item = count(self::generateEntityManager()->getRepository(OrderItem::class)->findAll());
        //увеличиваем на 1 единицу строку при итерации
        $last_order_items = 0;
        try{
            if(!is_numeric($input->getArgument('order_quantity'))){
                throw new \Exception('order_quantity must be number');
            }
            $entityManager= $this->generateEntityManager();
            // Сколько часов добавлять в времени по умолчанию в столбец create_datetime таблице Orders
            $hours = count($this->generateEntityManager()->getRepository(Order::class)->findAll());

            for ($i = 0; $i < $input->getArgument('order_quantity'); $i++){
                $datetime = new \DateTime();
                $newDate = $datetime->createFromFormat('Y-m-d H:i:s', '2018-01-01 09:00:00');
                $hour = $hours+$i;
                $newDate->modify("+ $hour hour");
                $order = new Order();
                $order->setCreateDatetime($newDate);
                $entityManager->persist($order);
                //количество order_items
                $count_order_items = rand(1,5);
                for ($j = 0; $j < $count_order_items; $j++){
                    $amount = rand(1,10);
                    $product_price=rand(100,9999);
                    if($last_order_items){
                        $prouct_line_number=$last_order_items;
                    }else{
                        if($last_order_item){
                            $prouct_line_number = $last_order_item;
                            $last_order_items = $last_order_item;
                        }else{
                            $prouct_line_number = ++$last_order_items;
                        }
                    }
                    $product_name='Товар-'.$prouct_line_number;
                    $item = new OrderItem();
                    $item->setAmount($amount);
                    $item->setOrderCustom($order);
                    $item->setProductName($product_name);
                    $item->setProductPrice($product_price);
                    $entityManager->persist($item);
                    $last_order_items++;
                }
            }


            $entityManager->flush();
        }catch (\Exception $exception){
            $output->writeln(array("","<info>".$exception->getMessage()."</info>",""));
        };
        $output->writeln(array("","<info> You generated orders</info>",""));
    }

    /**
     * @return EntityManager
     * description: get environment
     */
    static protected function generateEntityManager()
    {
        $env = \Env::get_env();
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), true);
        $entityManager = EntityManager::create(array(
            'dbname' => $env['dbname'],
            'user' => $env['user'],
            'password' => $env['password'],
            'host' => $env['host'],
            'driver' => $env['driver'],
        ), $config);
        return $entityManager;
    }
}