<?php

require '../application/model/database.php';
  /**
   * It is user Registration page.
   */
  class Register extends Framework {

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
     * It is managing two casses first when user submit registartion form and
     * another is when user send the request to this controller through url.
     * First case : After form submission it will fetch the data and check the
     * validations and then communicate with model for storing the data into
     * database.
     * Second Case : If user access through another method then if user logged
     * in then redirect to home page otherwise stay on registration page.
     *
     *   @return void
     *     It will not return any values;
     */
    public function index() {
      // When user submit registration form, it will validate the data and then
      // send to the model. If registration done then go to login page otherwise
      // stay on registartion page.
      if(isset($_POST['submitBtn'])) {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $password = $_POST['pwd'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $firstName = $this->testInput($firstName);
        $lastName = $this->testInput($lastName);
        $password = $this->testInput($password);
        $mobile = $this->testInput($mobile);
        $email = $this->testInput($email);
        $obj = new Database();
        $status = $obj->newUserValidation($firstName, $lastName, $password, $mobile, $email);

        // If all the user's data are valid then continue otherwise it will go to
        // the registartion page with error message.
        if($status[0]) {
          $GLOBALS['firstNameError'] = $status[1]['firstName'];
          $GLOBALS['lastNameError'] = $status[1]['lastName'];
          $GLOBALS['passwordError'] = $status[1]['password'];
          $GLOBALS['mobileError'] = $status[1]['mobile'];
          $GLOBALS['emailError'] = $status[1]['email'];
          $imgName = $_FILES['user_img']['name'];
          $imgTmp = $_FILES['user_img']['tmp_name'];
          $imgType = $_FILES['user_img']['type'];

          // It is checking the image type. If valid then continue otherwise go
          // to the registration page.
          if($imgType == "image/png" || $imgType == "image/jpeg" || $imgType == "image/jpg") {
            $GLOBALS['imageError'] = false;
            move_uploaded_file($imgTmp, "assets/uploads/". $imgName);
            $status = $obj->registerRequest($firstName, $lastName, $password,
            $mobile, $email, "/assets/uploads/$imgName");
            $GLOBALS['DuplicateErrorMsg'] = $obj->duplicateEmailMsg;
            if($status){
              $GLOBALS['DuplicateErrorMsg'] = $obj->duplicateEmailMsg;
              header("location: /userControl");
            }
            else {
              $GLOBALS['DuplicateErrorMsg'] = $obj->duplicateEmailMsg;
              $this->view("register");
            }
          }
          else {
            $GLOBALS['imageError'] = true;
            $this->view("register");
          }
        }
        else {
          $GLOBALS['firstNameError'] = $status[1]['firstName'];
          $GLOBALS['lastNameError'] = $status[1]['lastName'];
          $GLOBALS['passwordError'] = $status[1]['password'];
          $GLOBALS['mobileError'] = $status[1]['mobile'];
          $GLOBALS['emailError'] = $status[1]['email'];
          $this->view("register");
        }
      }
      else {
        session_start();
        if(isset($_SESSION['logged_in'])) {
          header("location: /home");
        }
        else {
          session_destroy();
          $this->view("register");
        }
      }
    }


  }
?>
