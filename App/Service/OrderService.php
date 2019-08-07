<?php
/**
 * Created by PhpStorm.
 * User: Pub
 * Date: 07.08.2019
 * Time: 5:17
 */

namespace App\Service;


use App\Repository\OrderRepository;
use App\Repository\ProductRepository;

class OrderService
{
    /**
     * Create order
     *
     * @param array $productIDs List of products
     *
     * @return integer
     *
     */
    public static function create($productIDs) {
        $products = ProductRepository::getByIDs($productIDs);

        $total = 0;
        foreach ($products as $product) {
            $total += $product['price'];
        }

        return OrderRepository::create($total, $productIDs);
    }

    /**
     * Pay order
     *
     * @param integer $id Order id
     * @param integer $total Order total
     *
     * @return void
     *
     */
    public static function pay($id, $total) {
        $order = OrderRepository::getById($id);

        if(($order['total'] == $total) && ($order['status'] == 0)) {
            $ch = curl_init( "http://ya.ru/" );
            $response = curl_exec( $ch );
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close( $ch );

            if($status == 200) {
                OrderRepository::pay($id);
            }
        }
    }

}