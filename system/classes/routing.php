<?php

  /**
   * Routing class is responsible for fetching request from url and response to
   * user with the help of controller.
   */
  class Routing {

    /**
     * It is default controller name
     *
     *   @var string
     */
    public $controller = "home";

    /**
     * It is defalut method of any controller
     *
     *   @var string
     */
    public $method = "index";

    /**
     * It will be store the parameter from url.
     *
     *   @var array
     */
    public $params = [];

    /**
     * When controller not found it will be false otherwise true.
     *
     *   @var bool
     */
    public $check = false;

    /**
     * When Routing class will be initialize it will call a getUrl function and
     * function will return a url which is array type and then according to
     * url array manage the request with the help of controller.
     *
     *   @return void
     */
    function __construct() {
      $url = $this->getUrl();
      if(!empty($url)) {
        if(file_exists("../application/controller/". $url[0] .".php")) {
          $this->controller = $url[0];
          unset($url[0]);
          $this->check = true;
        }
      }
      require_once "../application/controller/". $this->controller .".php";
      $this->controller = new $this->controller();

      if($this->check) {
        if(isset($url[1]) && !empty($url)) {
          if(method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
          }
        }

        if(isset($url)) {
          $this->params = $url;
        }
        else {
          $this->params = [];
        }
      }

      call_user_func_array([$this->controller, $this->method], $this->params);
		}

    /**
     * When Routing class will be initialize this call be called through contructor.
     * First it will fetch the url and then apply some validations after that return
     * url.
     *
     *   @return array
     *     $url which is fetched from url will be return.
     */
    function getUrl() {
      if (isset($_SERVER["REQUEST_URI"])) {
        $url = $_SERVER["REQUEST_URI"];
        $url = rtrim($url);
        $url = ucfirst($url);
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode("/", substr($url, 1));
      }
      return $url;
    }

	}

?>
