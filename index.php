<?php
    session_start();

    $err = "";

    if(array_key_exists("logout", $_GET)) {

        unset($_SESSION);
        session_destroy();
        setcookie("id", "", time() - 60 * 60);
        $_COOKIE['id'] = "";
    }
    else if (array_key_exists("id", $_COOKIE) OR (array_key_exists("id", $_SESSION))) {
        header("Location: diary.php");
    }


    if (array_key_exists("submit", $_POST)) {

        include("dbconnect.php");
        
        if (!$_POST['email']) {
            $err .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Email is required!!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
        if (!$_POST['pass']) {
            $err .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Password is required!!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
        if ($err != "") {
            $err = '<div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>There were error(s) in the form : </strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>'.$err;
        }
        else {

            if($_POST['signup'] == "1") {

            $email = mysqli_real_escape_string($link, $_POST['email']);
            $pass = mysqli_real_escape_string($link, $_POST['pass']);
            $name = mysqli_real_escape_string($link, $_POST['name']);

            $query = "SELECT id FROM `users` WHERE `email` = '$email' LIMIT 1";

            $run = mysqli_query($link, $query);

            $row = mysqli_num_rows($run);

            if ($row > 0) {
                $err = '<div class="alert alert-info alert-dismissible fade show" role="alert">
                Email is already taked!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
            else {
                $query = "INSERT INTO `users` (`email`, `password`, `name`) VALUES ('$email', '$pass', '$name')";

                $run = mysqli_query($link, $query);
                if (!$run) {
                    $err = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Could not sign you up! Database error!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                }
                else {
                    //Encrypting and Updating Password
                    $id = mysqli_insert_id($link);
                    $uPass = md5(md5($id).$pass);
                    $query = "UPDATE `users` SET `password` = '$uPass' WHERE `id` = '$id' LIMIT 1";
                    mysqli_query($link, $query);

                    $_SESSION['id'] = $id;
                    if ($_POST['keepLoggedIn'] == '1') {
                        setcookie("id", $id, time() + 60*60*24*365);
                    }

                    header("Location: diary.php");
                }
            }
          }
          else {
              $email = mysqli_real_escape_string($link, $_POST['email']);
              $pass = mysqli_real_escape_string($link, $_POST['pass']);

              $query = "SELECT * FROM `users` WHERE email = '$email'";
              $run = mysqli_query($link, $query);
              $row = mysqli_fetch_array($run);

              if(isset($row)) {
                  $enPass = md5(md5($row['id']).$pass);

                  if ($enPass == $row['password']) {
                    $_SESSION['id'] = $row['id'];
                    if ($_POST['keepLoggedIn'] == '1') {
                        setcookie("id", $row['id'], time() + 60*60*24*365);
                    }
                    header("Location: diary.php");
                  }
                  else {
                    $err = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Email and Password combination does not found!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>';
                }
  
              }
              else {
                  $err = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Email and Password combination does not found!
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
              }

          }

        }
    }


?>

<?php include("header.php"); ?>

    <section id="header" style="height: 100vh;">
        <?php include("navbar.php"); ?>
        </nav>
    <div class="container-fluid">
          <div class="row justify-content-center align-items-center" style="height: 65vh">
              
                <div class="col-xl-10 text-light p-md-5">
                <!-- Error Handling -->
                  <div id="error"><?php echo $err; ?></div>
                  <!-- Error Hanlding end -->
                    <h1 class="heading display-4"><span class="text-warning">100% Secure</span> Online <span class="text-danger">Diary</span></h1>
                            <p class="text-muted sub-text mt-3">“Each new day is a blank page in the diary of your life.<br> The secret of success is in turning that diary into the best story you possibly can.”</p>
                                <!-- Button trigger modal -->
                                <div class="text-center text-md-left mt-5">
                                <button type="button" class="btn btn-success btn-lg button-1" data-toggle="modal" data-target="#modal">
                                  Log In &raquo;
                                </button>
                                <button type="button" class="btn btn-outline-light btn-lg button-1 ml-3" data-toggle="modal" data-target="#modal2">
                                  Register &raquo;
                                </button>
                                </div>
                </div>
            </div>
        </div>

    <!-- Button trigger modal -->

 


<!-- Modal -->
<div class="modal fade bg-dark" id="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Log in &raquo;</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post" action="index.php">
        <div class="form-group">
            <label for="InputEmail1">Email address</label>
            <input type="email" name="email" class="form-control bg-dark text-success" id="InputEmail1" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="InputPassword1">Password</label>
            <input type="password" name="pass" class="form-control bg-dark text-success" id="InputPassword1" placeholder="Password">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="Check1" name="keepLoggedIn" value=1>
            <label class="form-check-label"  for="Check1">Keep me looged in</label>
        </div>
        <input type="hidden" name="signup" value="0">
        <input type="submit" name="submit" class="btn btn-success btn-lg button-1" value="Log In &raquo;">
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bg-dark" id="modal2" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sign Up &raquo;</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post" action="index.php">
            <div class="form-group">
            <label for="InputName">Your Name</label>
            <input type="text" name="name" class="form-control bg-dark text-success" id="InputEmail1" placeholder="Enter Your Name">
        </div>
        <div class="form-group">
            <label for="InputEmail1">Email address</label>
            <input type="email" name="email" class="form-control bg-dark text-success" id="InputEmail1" placeholder="Enter email">
            <small id="emailHelp" class="form-text text-success">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="InputPassword1">Password</label>
            <input type="password" name="pass" class="form-control bg-dark text-success" id="InputPassword1" placeholder="Password">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="keepLoggedIn" value=1 id="Check1">
            <label class="form-check-label"  for="Check1">Keep me looged in</label>
        </div>
        <input type="hidden" name="signup" value="1">
        <input type="submit" name="submit" class="btn btn-success btn-lg button-1" value="Register &raquo;">
        </form>
      </div>
    </div>
  </div>
</div>
<?php include("footer.php"); ?>
