<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Exception\ActionChargementFail;
    use Composants\Framework\Exception\ControllerChargementFail;
    use Composants\Framework\Exception\GetChargementFail;
    use Composants\Framework\Exception\RouteChargementFail;

    /**
     * Class FailFactory
     * @package Composants\Framework\Exception
     */
    class FailFactory{
        /**
         * @param string $action
         * @return \Composants\Framework\Exception\ActionChargementFail
         */
        public function action($action){
            return new ActionChargementFail($action);
        }

        /**
         * @param string $controller
         * @return \Composants\Framework\Exception\ControllerChargementFail
         */
        public function controller($controller){
            return new ControllerChargementFail($controller);
        }

        /**
         * @return \Composants\Framework\Exception\GetChargementFail
         */
        public function get(){
            return new GetChargementFail();
        }

        /**
         * @param string $route
         * @return \Composants\Framework\Exception\RouteChargementFail
         */
        public function route($route){
            return new RouteChargementFail($route);
        }
    }