<?php

require '../application/model/database.php';
  /**
   * It is Home page of where all book data wll be available.
   */
  class Home extends Framework {

    public function index() {
      session_start();
      if(isset($_SESSION['logged_in'])) {
        $obj = new Database();
        $bookList = $obj->fetchBooks();

        if($bookList != null) {
          $_SESSION['bookList'] = $bookList;
        }
        $this->view("home");
      }
      else {
        session_destroy();
        header("location: /login");
      }
    }


    /**
     * It is responsible for destroy the session and then redirect to login page.
     *
     *   @return void
     */
    public function logout() {
      session_start();
      session_unset();
      session_destroy();

      header("location: /login");
    }


  }
?>
