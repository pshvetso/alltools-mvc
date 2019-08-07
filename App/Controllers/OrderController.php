<?php
/**
 * Created by PhpStorm.
 * User: Pub
 * Date: 05.08.2019
 * Time: 23:56
 */

namespace App\Controllers;

use App\Service\OrderService;
use Core\Controller;

/**
 * Order controller
 *
 *
 */
class OrderController extends Controller {

    /**
     * Create order
     * Usage: http://localhost/order/create?ids[]=1&ids[]=2&ids[]=3
     *
     * @param array $ids Product IDs
     *
     * @return integer
     *
     */
    public function createAction($ids) {
        return OrderService::create($ids);
    }

    /**
     * Pay order
     * Usage: http://localhost/order/pay?id=10&total=64519
     *
     * @param integer $id Order ID
     * @param integer $total Order total
     *
     * @return array
     *
     */
    public function payAction($id, $total) {
        OrderService::pay($id, $total);
        return ["response" => "ok"];
    }
}
