<?php

  class Database extends Connection {

    /**
     * It store the login user's email exists or not in boolean form.
     *
     *   @var bool
     */
    public $emailErrorMsg = false;

    /**
     * It store the login user's password exists or not in boolean form.
     *
     *   @var bool
     */
    public $pwdErrorMsg = false;

    /**
     * validationMsg
     *
     *   @var array
     */
    public $validationMsg = [];

    /**
     * duplicateEmailMsg
     *
     *   @var bool
     */
    public $duplicateEmailMsg;

    /**
     * It store all the books.
     *
     * @var array
     */
    public $bookData = [];

    /**
     * It manage the user login operation. It will called by controller for
     * validating the user's entered data for login.
     *
     *   @param  string $userEmail
     *     It store the user email.
     *
     *   @param  string $userPassword
     *     It store the user password.
     *
     *   @return void
     *     If user's entered valid data then return true otherwise return false.
     */
    public function loginRequest($userEmail, $userPassword) {
      $fetch = "SELECT * FROM Account WHERE UserEmail = '$userEmail'";
      $result = $this->conn->query($fetch);
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($userPassword === $row["UserPassword"]){
          $this->emailErrorMsg = false;
          $this->pwdErrorMsg = false;
          return true;
        }
        else {
          $this->pwdErrorMsg = true;
          return false;
        }
      }
      else {
        $this->emailErrorMsg = true;
        return false;
      }

      $this->conn->close();
    }

    /**
     * It is managing the use registartion.
     *
     *   @param  string $userFirstName
     *     It store the user first name.
     *
     *   @param  string $userLastName
     *     It store the user last mame.
     *
     *   @param  string $userPassword
     *     It store the user password.
     *
     *   @param  string $userMobile
     *     It store the user's mobile number.
     *
     *   @param  string $userEmail
     *     It store the user Email address.
     *
     *   @param  string $userImage
     *     It stote the user image file address.
     *
     *   @return bool
     *     When regisrartion done successfully it will retur true other wise false.
     */
    public function registerRequest($userFirstName, $userLastName, $userPassword, $userMobile, $userEmail, $userImage) {
      $check_sql = "SELECT UserEmail FROM Account WHERE UserEmail = '$userEmail'";

      $result = $this->conn->query($check_sql);

      if ($result->num_rows > 0) {
        $this->duplicateEmailMsg = true;
        return false;
      }
      else{
        $post = "INSERT INTO Account (FirstName, LastName, UserPassword, UserMobile, UserEmail, UserImg)
        VALUES('$userFirstName', '$userLastName', '$userPassword', '$userMobile', '$userEmail', '$userImage')";
        if($this->conn->query($post)) {
          $this->duplicateEmailMsg = false;
          return true;
        }
        else {
          return false;
        }
      }
      $this->conn->close();
    }

    /**
     * It is managing the admin login
     *
     *   @param  string $adminEmail
     *     It store the admin email.
     *
     *   @param  string $adminPassword
     *     It store the admin password.
     *
     *   @return void
     *      If admin's entered valid data then return true otherwise return false.
     */
    public function adminLoginRequest($adminEmail, $adminPassword) {
      if($adminEmail === "abhishek.kumar@innoraft.com") {
        if($adminPassword === "abhi31@I"){
          $this->emailErrorMsg = false;
          $this->pwdErrorMsg = false;
          return true;
        }
        else {
          $this->pwdErrorMsg = true;
          return false;
        }
      }
      else {
        $this->emailErrorMsg = true;
        return false;
      }
    }

    /**
     *It manage the added the books by author.
     *
     *   @param  string $bookTitle
     *     It stores the book title.
     *
     *   @param  string $bookImage
     *     It stores the book image.
     *
     *   @param  string $bookDesc
     *     It store the book description.
     *
     *   @param  string $bookCost
     *    It store the book cost.
     *
     *   @param  string $bookAuthor
     *     It store the book author name.
     *
     *   @return bool
     *     If book added successfully then return true otherwise return false;
     */
    public function addBooks($bookTitle, $bookImage, $bookDesc, $bookCost, $bookAuthor) {
      $post = "INSERT INTO bookList (bookTitle, bookImage, bookDesc, bookCost, bookAuthor)
      VALUES('$bookTitle', '$bookImage', '$bookDesc', '$bookCost', '$bookAuthor')";
      if($this->conn->query($post)) {
        return true;
      }
      else {
        return false;
      }
    }

    /**
     * It fetch all the book data from database and return back to the controller.
     *
     *   @return mixed
     *     If book avilable then return list of books otherwise return null.
     */
    public function fetchBooks() {
      $check_sql = "SELECT * FROM bookList";

      $result = $this->conn->query($check_sql);
      if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          $bookData[] = $row;
        }
        return $bookData;
      }
      return null;
    }

    /**
     * It is managing the user input data validations.
     *
     *   @param  string $firstName
     *     It store user first name.
     *
     *   @param  string $lastName
     *     It store user last name.
     *
     *   @param  string $password
     *     It store the user password.
     *
     *   @param  string $mobile
     *     It store the user mobile number.
     *
     *   @param  string $email
     *     It store the user email.
     *
     *   @return array
     *     It will return an array in which first index will hold overall validations
     *     status and another index store another which consists status of all
     *     the data.
     */
    public function newUserValidation($firstName, $lastName, $password, $mobile, $email) {
      if(preg_match("/^[A-Za-z]+$/", $firstName)) {
        $this->validationMsg['firstName'] = true;
      }
      else {
        $this->validationMsg['firstName'] = false;
      }
      if(preg_match("/^[A-Za-z]+$/", $lastName)) {
        $this->validationMsg['lastName'] = true;
      }
      else {
        $this->validationMsg['lastName'] = false;
      }
      if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/", $password)) {
        $this->validationMsg['password'] = true;
      }
      else {
        $this->validationMsg['password'] = false;
      }
      if(preg_match("/^(\+91)[0-9]{10}$/", $mobile)) {
        $this->validationMsg['mobile'] = true;
      }
      else {
        $this->validationMsg['mobile'] = false;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->validationMsg['email'] = true;
      }
      else {
        $this->validationMsg['email'] = false;
      }

      foreach($this->validationMsg as $status) {
        if($status === false) {
          return [false, $this->validationMsg];
        }
      }
      return [true, $this->validationMsg];
    }

  }

?>
