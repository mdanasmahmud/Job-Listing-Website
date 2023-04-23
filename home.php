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
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Unexpired Jobs</h3>
      <a href="all_jobs.php" class="white-btn">
         <?php 

         $total_vacant = mysqli_query($conn, "SELECT COUNT(*) AS num_jobs
         FROM jobs_posted
         WHERE job_post_status = 'Approved' AND job_expiration_date > CURDATE()") or die('query failed');

         echo mysqli_num_rows($total_vacant);
         ?>
      </a>
   </div>

</section>

<section class="joblist">

   <h1 class="title">latest Jobs</h1>

   <div class="box-container">

      <?php  
         $select_jobs = mysqli_query($conn, "SELECT * FROM `jobs_posted` LIMIT 3") or die('query failed');
         if(mysqli_num_rows($select_jobs) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_jobs)){
      ?>
     <form action="" method="post" class="box">
      <div class="qty"><?php echo $fetch_products['job_title']; ?><br></div>
      <div class="price"><?php echo $fetch_products['job_type']; ?></div>
     </form>
      <?php
         }
      }else{
         echo '<p class="empty">No Jobs Has Been Posted Yet</p>';
      }
      ?>
   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="all_jobs.php" class="option-btn">load more</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>We are a student of CSE471 Group 12</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>You can send us a mail or even better, contact us through the button below</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>