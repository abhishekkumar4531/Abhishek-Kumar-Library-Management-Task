<?php

  /**
   * Framework class is generally managing the view part.
   */
  class Framework {

    /**
     * It is responsible for finding the view file and if exist then reauire it
     * otherwise be default redirect to login page.
     *
     *   @param  string $fileName
     *     It stores the view file name
     *
     *   @return void
     */
    public function view($fileName) {
      if(file_exists("../application/view/". $fileName .".php")) {
        require_once "../application/view/$fileName.php";
      }
      else {
        echo "<script>alert('Error!!!');</script>";
        $this->view("login");
      }
    }

  }

?>
