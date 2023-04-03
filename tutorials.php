<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'job_seeker'){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tutorial Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Tutorials</h3>
   <p> <a href="home.php">Home</a> / Tutorials </p>
</div>

<section class="joblist">

   <h1 class="title">latest Videos</h1>

</section>

<section class="show-products">

   <div class="box-container" style="grid-template-columns: repeat(auto-fit, 50rem); justify-content: center;">
      

      <form action="" method="post" class="box" style="text-align: center;">
      <div class="name">How To Create A CV</div>
      <iframe width="440" height="215" src="https://www.youtube.com/embed/_fP43gcBywU" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

      </form>
      
   </div>
</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>