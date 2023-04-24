<?php

require '../application/model/database.php';
  /**
   * It manage admin login page.
   */
  class AdminLogin extends Framework {

    function testInput($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    public function index() {
      if(isset($_POST['submitAdminLogin'])) {
        $adminEmail = $_POST['useremail'];
        $adminPwds = $_POST['userpassword'];

        $adminEmail = $this->testInput($adminEmail);
        $adminPwds = $this->testInput($adminPwds);

        $obj = new Database();
        $login_status = $obj->adminLoginRequest($adminEmail, $adminPwds);
        $GLOBALS['emailErrorStatus'] = $obj->emailErrorMsg;
        $GLOBALS['pwdErrorStatus'] = $obj->pwdErrorMsg;

        // If user logged in then store the user email in session variable and
        // redirect to login page.
        if($login_status) {
          session_start();
          $_SESSION['logged_in'] = $adminEmail;
          $_SESSION['admin_logged'] = TRUE;
          header("location: /add");
        }
        else {
          $this->view("login");
        }
      }
      else {
        session_start();
        if(isset($_SESSION['logged_in'])) {
          header("location: /home");
        }
        else {
          session_destroy();
          $this->view("adminLogin");
        }
      }
    }


  }
?>
