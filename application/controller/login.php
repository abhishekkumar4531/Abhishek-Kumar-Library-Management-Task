<?php

require '../application/model/database.php';
  /**
   * Login is managing the login form, when user submit their login form then it]
   * will after validation redirect to home page.
   * If user without form submission try to access this page then if user login
   * then redirefct to home page otherwise stay on home page.
   */
  class Login extends Framework {

    /**
     * It is validating the input feild.
     *
     *   @param  string $data
     *     It will store input feild data.
     *
     *   @return sring
     *     Adter validating it will return string type data.
     */
    function testInput($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    /**
     * It is managing two casses first when user submit their login form and
     * another is when user try to access by url
     * First case : After form submission it will fetch the data and then
     * communicate with model for checking the user's entered data, if user is
     * valid then redirect to home page otherwise stay on login page with error
     * message.
     *
     *   @return void
     *     It will not return any values;
     */
    public function index() {
      if(isset($_POST['submitLogin'])) {
        $userEmail = $_POST['useremail'];
        $userPwds = $_POST['userpassword'];

        $userEmail = $this->testInput($userEmail);
        $userPwds = $this->testInput($userPwds);

        $obj = new Database();
        $login_status = $obj->loginRequest($userEmail, $userPwds);
        $GLOBALS['emailErrorStatus'] = $obj->emailErrorMsg;
        $GLOBALS['pwdErrorStatus'] = $obj->pwdErrorMsg;

        // If user logged in then store the user email in session variable and
        // redirect to login page.
        if($login_status) {
          session_start();
          $_SESSION['logged_in'] = $userEmail;
          header("location: /home");
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
          $this->view("login");
        }
      }
    }




  }
?>
