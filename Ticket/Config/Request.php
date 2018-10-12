<?php namespace Config;
    class Request {

        private $controller;
        private $method;
        private $params;

        public function __construct() {
            /**
              *  En el archivo htaccess se define una regla de reescritura para poder tomar la url tanto para todo metodo de petición.
              */
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);//"sanitiza la url en busqueda de datos privados que no
            /**                                                           deben ir por metodo GET, ej: usuarios y contraseñas"
             * Convierto la url en un array tomando como separador la "/".
             */
            $urlToArray = explode("/", $url);
            /**
             * Filtro el arreglo para eliminar datos vacios en caso de haberlos.
             */
            $ArrayUrl = array_filter($urlToArray);
            print_r($ArrayUrl);
            /**
             * Defino un controlador por defecto en el caso de que el arreglo llegue vacío
             *
             * Si el arreglo tiene datos, tomo como controlador el primer elemento.
             */
            if(empty($ArrayUrl)) {
                $this->$controller = 'home';
            } else {
                $this->$controller = ucwords(array_shift($ArrayUrl));//array_shift traspasa/elimina el primer dato en el arreglo
            }
            /**
             * Defino un método por defecto en el caso de que el arreglo llegue vacío
             *
             * Si el arreglo tiene datos, tomo como método el primero elemento.
             */
            if(empty($ArrayUrl)) {
                $this->method = 'index';
            } else {
                $this->method = array_shift($ArrayUrl);
            }
            /**
             * Capturo el metodo de petición y lo guardo en una variable
             */
            $methodRequest = $this->getMethodRequest();
            /**
             * Si el método es GET, en caso de que el arreglo llegue con datos,
             * lo guardo entero en el campo "parametros" de la  clase.
             *
             * Si el método es POST, guardo todos los datos que llegaron por POST
             * en el campo "parametros"
             */
            if($methodRequest == 'GET') {
                if(!empty($ArrayUrl)) {
                    $this->params = $ArrayUrl;
                }
            } else {
                $this->params = $_POST;
            }
        }
        /**
         *
         */
        public static function getInstance()
        {
            static $instance = null;
            if ($instance === null) {
                $instance = new Request();
            }
            return $instance;
        }
        /**
        * Devuelve el método HTTP
        * con el que se hizo el
        * Request
        *
        * @return String
        */
        public static function getMethodRequest()
        {
            return $_SERVER['REQUEST_METHOD'];
        }
        /**
        * Devuelve el controlador
        *
        * @return String
        */
        public function getController() {
            return $this->controller;
        }
        /**
        * Devuelve el método
        *
        * @return String
        */
        public function getMethod() {
            return $this->method;
        }
        /**
        * Devuelve los atributos
        *
        * @return Array
        */
        public function getParams() {
            return $this->params;
        }
    }
