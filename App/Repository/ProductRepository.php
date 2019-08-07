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

class ProductRepository extends Repository
{
    /**
     * Init database
     *
     * @return void
     */
    public static function init() {

        $db = static::getDB();
        $db->beginTransaction();

        $query = 'CREATE TABLE `product` (
            `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `title` text NOT NULL,
            `price` int(11) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        $stmt = $db->query($query);

        $query = 'CREATE TABLE `order` (
            `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
            `total` int(11) NOT NULL,
            `status` tinyint(1) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        $stmt = $db->query($query);

        $query = 'CREATE TABLE `order_product` (
            `order_id` int(11) NOT NULL,
            `product_id` int(11) NOT NULL,
            PRIMARY KEY (`order_id`, `product_id`),
            FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
            FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
        $stmt = $db->query($query);

        $query = 'INSERT INTO `product` (`title`, `price`) VALUES 
            ("Смартфон Samsung Galaxy S8+ 64GB", 30900),
            ("Компьютерная акустика Edifier R2800", 19440),
            ("Компьютерная гарнитура Sennheiser GSP 500", 14179),
            ("Наушники Sennheiser Urbanite XL i", 9087),
            ("Наушники Sony MDR-7506", 6950),
            ("Внешняя звуковая карта Creative Sound Blaster Omni Surround 5.1", 5125),
            ("Наушники Sony MDR-V55", 4035),
            ("Компьютерная акустика SVEN MA-332", 1234),
            ("Смартфон Samsung Galaxy S6 Edge+ 32GB", 23456),
            ("Компьютерная гарнитура Sennheiser PC 320", 2345),
            ("Наушники Beyerdynamic Custom One Pro Plus", 12215),
            ("Планшет Samsung Galaxy Tab 4 10.1 SM-T533 16Gb", 12345),
            ("Планшет Samsung Galaxy Tab S3 9.7 SM-T825 LTE 32Gb", 40534),
            ("Планшет Samsung Galaxy Tab S4 10.5 SM-T835 64Gb", 40990),
            ("Планшет Samsung Galaxy Tab S5e 10.5 SM-T725 64Gb", 30900),
            ("Автомагнитола KENWOOD DMX6018BT", 20260),
            ("Автомагнитола JVC KW-V230BT", 15299),
            ("Автомагнитола Pioneer AVH-Z5100BT", 23520),
            ("Автомагнитола Pioneer SPH-DA120", 22790),
            ("Смартфон Xiaomi Redmi Note 5 4/64GB", 10580);';
        $stmt = $db->query($query);

        $db->commit();
    }

    /**
     * Get all the entries as an associative array
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT `id`, `title`, `price` FROM `product`;');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get products by IDs
     *
     * @param array $productIDs Product IDs
     *
     * @return array
     *
     */
    public static function getByIDs($productIDs) {
        $db = static::getDB();

        $in  = str_repeat('?,', count($productIDs) - 1) . '?';
        $sql = "SELECT `id`, `title`, `price` FROM `product` WHERE `id` IN ($in)";
        $stmt = $db->prepare($sql);
        $stmt->execute($productIDs);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}