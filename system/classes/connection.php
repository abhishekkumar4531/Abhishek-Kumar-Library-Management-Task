<?php

  /**
   * Connection - This class is used for database connection.
   */
  class Connection {

    public $user = "root";
    public $host = "localhost";
    public $db = "Social";
    public $pwd = "Abhi4531@my";
    public $conn;

    /**
     * When Connection call will be initilize it will be execute and make the
     * connection with database.
     *
     *   @return void
     */
    function __construct() {
      $this->conn = new mysqli($this->host, $this->user, $this->pwd, $this->db);
    }

  }

?>
