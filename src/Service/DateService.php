<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 12.01.2020
 * Time: 17:36
 */

namespace App\Service;


use Symfony\Component\HttpFoundation\Request;

class DateService
{
    /**
     * @var Request
     */
    private $request;

    public function set_request(Request $request):void
    {
        $this->request = $request;
    }

    public function get_date_from():string
    {
        return ($this->request->query->get('from_date')) ? $this->request->query->get('from_date').' '.$this->request->query->get('from_time') : '2018-01-01 09:00';
    }
    public function get_date_to():string
    {
        return ($this->request->query->get('to_date')) ? $this->request->query->get('to_date').' '.$this->request->query->get('to_time') : (new \DateTime())->format('Y-m-d H:i');
    }
}