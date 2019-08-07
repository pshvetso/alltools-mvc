<?php
/**
 * Created by PhpStorm.
 * User: Pub
 * Date: 07.08.2019
 * Time: 5:17
 */

namespace App\Controllers;

use App\Repository\ProductRepository;
use Core\Controller;

/**
 * Product controller
 *
 *
 */
class ProductController extends Controller {

    /**
     * Initialize database
     *
     * @return array
     *
     */
    public function initAction() {
        ProductRepository::init();
        return ["response" => "ok"];
    }

    /**
     * Get all the products
     *
     * @return array
     *
     */

    public function getAllAction() {
        return ProductRepository::getAll();
    }
}
