<?php
    session_start();

    $name = "";
    $diaryContent = "";
    date_default_timezone_set('Asia/Kolkata');

    if(array_key_exists("id", $_COOKIE )) {

        $_SESSION['id'] = $_COOKIE['id'];
    }

    if (array_key_exists("id", $_SESSION)) {
        include("dbconnect.php");
        $uid = $_SESSION['id'];
        $query = "SELECT * FROM `users` WHERE id = '$uid'";
        $run = mysqli_query($link, $query);
        $row = mysqli_fetch_array($run);
        $name = $row['name'];
        $diaryContent = $row['diary'];

        $logout = "<a class='nav-link text-white btn btn-danger button-1' href='index.php?logout=1'>Log Out</a>";
    }
    else {
        header("Location: index.php");
    }


?>
<?php include("header.php"); ?>

    <section id="header">
     <?php include("navbar.php");?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto text-center">
      <li class="nav-item">
        <a class="nav-link text-white h6"><span class="text-info">Hi, </span> <span class="text-warning"><?php echo $name; ?></span></a>
      </li>
      <li class="nav-item">
        <?php echo $logout; ?>
      </li>
    </ul>
  </div>
    </nav>

    <div class="container-fluid">
      <textarea class="form-control" id="diary-text"><?php echo $diaryContent ?><?php echo "\n"."\n".date("d, M, Y - h:i A")." >>> \n";  ?></textarea>
      <br>
    </div>





<?php include("footer.php"); ?>

</section>