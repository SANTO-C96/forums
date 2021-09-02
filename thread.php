<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

    <title>Welcome to iDiscuss - coding forums </title>
</head>

<body>
    <?php include '_dbconnect.php'; ?>
    <?php include '_header.php'; ?>
    
    <?php

    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
        $sql2="SELECT user_email FROM `users` WHERE sno=$thread_user_id ";
            $result2 = mysqli_query($conn, $sql2);
            $row2=mysqli_fetch_assoc($result2);
            $posted_by=$row2['user_email'];
    }

    ?>
    <?php
    $showalert=false;
    $method= $_SERVER['REQUEST_METHOD'];
    if($method=='POST')
    {
        //insert into database comment 

        $comment = $_POST['comment'];
        $sno = $_POST['sno'];
        $sql="INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) 
        VALUES ( '$comment', '$id', current_timestamp(), '$sno');";
        $result = mysqli_query($conn, $sql);
        $showalert=true;
        if($showalert)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>success </strong> your comment has been added .
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }

    }
    
    ?>
    <div class="container my-4">
        <div class="jumbotron">

            <h1 class="display-4"> <?php echo $title; ?> forums </h1>
            <p class="lead"> <?php echo $desc; ?></p>
            <hr class="my-4">
            <p>this is peer to peer forum sharing knowledege to each other . No Spam / Advertising / Self-promote in
                the forums is not allowed
                Do not post copyright-infringing material. ...
                Do not post “offensive” posts, links or images. ...
                Do not cross post questions. ...
                Remain respectful of other members at all times.</p>
            <p>
                <b> posted by : <?php echo $posted_by; ?> </b>
            </p>
        </div>

    </div>
    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true)
    {
   echo ' <div class="container">
        <h1 class="py-2"> Post a comment  </h1>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label"> type your comment  </label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success">Post comment </button>
        </form>
    </div>';
  }
  else {
    echo '
    <div class="container">
    <h1 class="py-2"> post comment </h1>
    <p class="lead"> you are not logged in. please login to be able to start a posting comment   </p>
    </div>
   ';
  }
    ?>
    <div class="container my-4">

        <h1>Discussion </h1>

         <?php


                $id = $_GET['threadid'];
                $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
                $result = mysqli_query($conn, $sql);
                $noresult=true;
                while ($row = mysqli_fetch_assoc($result)) {
                    $noresult=false;
                    $id = $row['comment_id'];
                    $content = $row['comment_content'];
                    $comment_time =$row['comment_time'];
                    $thread_user_id= $row['comment_by'];
            $sql2="SELECT user_email FROM `users` WHERE sno=$thread_user_id ";
            $result2 = mysqli_query($conn, $sql2);
            $row2=mysqli_fetch_assoc($result2);
                    

                    echo '<div class="media my-4">
          <img class="mr-3" src="userdefault.png" width="50px" alt="Generic placeholder image">
          <div class="media-body">
          <p class="font-weight-bold my-0"> '.$row2['user_email'].'at '.$comment_time.'</p>
              
              ' . $content . '
              
          </div>
      </div>';
                }
                if ($noresult) {
                    echo '<div class="jumbotron jumbotron-fluid">
                  <div class="container">
                    <h1 class="display-4"> there is no any comment on this topic  </h1>
                    <p class="lead">Be the first person to comment on this topic  </p>
                  </div>
                </div>';
                }
                ?>

                
        






        <?php include '_footer.php'; ?>



        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    -->
</body>

</html>