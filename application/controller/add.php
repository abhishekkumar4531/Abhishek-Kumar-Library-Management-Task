<?php

require '../application/model/database.php';
  /**
   * It manage adding books by Author.
   */
  class Add extends Framework {

    /**
     * Whenever request come to this controller first it will check from where
     * request is coming, if request is coming after form submission then fetch
     * the book data and store into database and if some one directly try to
     * acess it then if admin login then open this page otherwise resirect to
     * the login page.
     *
     *   @return void
     *     It is return any value.
     */
    public function index() {
      if(isset($_POST['addBtn'])) {
        $bookTitle = $_POST['bookTitle'];
        $bookDesc = $_POST['bookDesc'];
        $bookCost = $_POST['bookCost'];
        $bookAuthor = $_POST['bookAuthor'];
        $imgName = $_FILES['bookImage']['name'];
        $imgTmp = $_FILES['bookImage']['tmp_name'];
        $imgType = $_FILES['bookImage']['type'];

        // It is checking the image type. If valid then continue otherwise go
        // to the add page with error message.
        if($imgType == "image/png" || $imgType == "image/jpeg" || $imgType == "image/jpg") {
          $GLOBALS['imageError'] = false;
          move_uploaded_file($imgTmp, "assets/uploads/". $imgName);

          $obj = new Database();
          $bookCost = number_format($bookCost);
          $status = $obj->addBooks($bookTitle, "/assets/uploads/$imgName",
          $bookDesc, $bookCost, $bookAuthor);

          //If book added successfully then redirect to home page.
          if($status) {
            header("location : /home");
          }
          else {
            $this->view("add");
          }
        }
        else {
          $GLOBALS['imageError'] = false;
          $this->view("add");
        }
      }
      else {
        session_start();
        if(isset($_SESSION['logged_in']) && isset($_SESSION['admin_logged'])) {
          $this->view("add");
        }
        else {
          session_destroy();
          header("location: /adminLogin");
        }
      }
    }

  }
?>
