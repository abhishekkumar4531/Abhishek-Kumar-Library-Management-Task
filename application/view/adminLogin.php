<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin-Login</title>
  <?php include "components/header.php" ?>
</head>
<body class="parent-tag">
  <?php include "components/navbar.php" ?>
  <div class="container">
    <div class="form-content">
      <div class="form-field">
        <h1>Admin Log-in Page</h1>
          <form action="/adminLogin" method="post">
            <dl>
              <dt>Enter User-Email</dt>
              <dd>
                <input type="text" name="useremail" id="email" placeholder="Enter User-Email" required onblur="checkEmailStatus()"
                value = "<?php if(isset($_POST['useremail'])){echo $_POST['useremail'];} ?>"
                >
              </dd>
              <dd id="email_success" class="success-msg"></dd>
              <dd id="email_status" class="error-msg"></dd>
              <dd class="error-msg">
                <?php
                  if(isset($GLOBALS['emailErrorStatus']) && $GLOBALS['emailErrorStatus']) {
                    echo "Please Enter Valid User-Email";
                  }
                ?>
              </dd>
              <dt>Enter User-Password</dt>
              <dd>
                <input type="password" name="userpassword" id="pwd" placeholder="Enter User-Password" required onblur="checkPasswordStatus()"
                value = "<?php if(isset($_POST['userpassword'])){echo $_POST['userpassword'];} ?>"
                >
              </dd>
              <dd id="pwd_success" class="success-msg"></dd>
              <dd id="pwd_status" class="error-msg"></dd>
              <dd class="error-msg">
              <?php
                if(isset($GLOBALS['pwdErrorStatus']) && $GLOBALS['pwdErrorStatus']) {
                  echo "Please Enter Valid User-Password";
                }
              ?>
              </dd>

              <dd>
                <button name="submitAdminLogin" id="submitBtn">Login</button>
              </dd>
              <dd>
                <a href="/register">New user?</a>
              </dd>
            </dl>
          </form>
      </div>
    </div>
  </div>
</body>
</html>
