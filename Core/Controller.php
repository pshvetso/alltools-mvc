<?php
/**
 * Created by PhpStorm.
 * User: Pub
 * Date: 07.08.2019
 * Time: 5:17
 */

namespace Core;

/**
 * Base controller
 *
 * 
 */
abstract class Controller
{

    /**
     * Call controller action and return result as JSON.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     * 
     * @throws \Exception
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                //echo("call_user_func_array");
                $args = array_values($args[0]);
                //print_r($args);
                $result = call_user_func_array([$this, $method], $args);
                echo json_encode($result);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }
}
