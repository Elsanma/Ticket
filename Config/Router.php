<?php namespace Config;
    class Router {
        /**
         * Se encarga de direccionar a la pagina solicitada
         *
         * @param Request
         */
        public static function direct(Request $request) {
            /**
             *
             */
            $controller =  'controller'. $request->getController();
            echo $controller;echo '<br>';
            /**
             *
             */
            $method = $request->getMethod();
            echo $method;echo '<br>';
            /**
             *
             */
            $params = $request->getParams();
            print_r ($params);
            /**
             *
             */
            $view = "controllers\\". $controller;
            /**
             *
             */
            $controller = new $view;
            /**
             *
             */
            if(!isset($params)) {
                call_user_func(array($controller, $method));
            } else {
                call_user_func_array(array($controller, $method), $params);
            }
        }
    }
