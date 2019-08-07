<?php
/**
 * Created by PhpStorm.
 * User: Pub
 * Date: 07.08.2019
 * Time: 5:17
 */

namespace App\Repository;

use Core\Repository;
use PDO;

class OrderRepository extends Repository
{
    /**
     * Create order
     *
     * @param integer $total Total price
     *
     * @return integer
     */
    public static function create($total, $productIDs) {
        $db = static::getDB();

        $db->beginTransaction();

        $query = 'INSERT INTO `order` (`total`, `status`) VALUES (:total, 0);';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':total', $total);
        $stmt->execute();

        $orderId = $db->lastInsertId();

        foreach($productIDs as $productId) {
            $query = 'INSERT INTO `order_product` (`order_id`, `product_id`) VALUES (:order_id, :product_id);';
            $stmt = $db->prepare($query);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':product_id', $productId);
            $stmt->debugDumpParams();
            $stmt->execute();
        }

        $db->commit();

        return $orderId;
    }

    /**
     * Get order by id
     *
     * @param integer $id Order id
     *
     * @return array
     *
     */
    public static function getById($id) {
        $db = static::getDB();

        $sql = "SELECT `id`, `total`, `status` FROM `order` WHERE `id` = :id;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
    }

    /**
     * Set order as payed
     *
     * @param integer $id Order id
     *
     * @return void
     *
     */
    public static function pay($id) {
        $db = static::getDB();

        $query = 'UPDATE `order` SET `status` = 1 WHERE `id` = :id;';
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}