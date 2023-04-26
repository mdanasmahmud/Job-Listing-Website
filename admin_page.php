<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'admin'){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="title">Admin Dashboard</h1>

   <div class="box-container">
      <div class="box">
         <?php
            $total_job_posts = 0;
            $select_completed = mysqli_query($conn, "SELECT COUNT(*) as total_job_posts FROM jobs_posted WHERE job_post_status='Approved'") or die('query failed');
            if(mysqli_num_rows($select_completed) > 0){
               while($fetch_earned = mysqli_fetch_assoc($select_completed)){
                  $total_job_posts = $fetch_earned['total_job_posts'];
               };
            };
         ?>
         <h3><?php echo $total_job_posts; ?></h3>
         <p>Active Job Post</p>
      </div>

      <div class="box">
         <?php
            $select_pendings = mysqli_query($conn, "SELECT COUNT(*) as total_pendings FROM jobs_posted WHERE job_post_status='Pending'") or die('query failed');
            $number_of_pendings = 0;
            if(mysqli_num_rows($select_pendings) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_pendings)){
                  $number_of_pendings = $fetch_users['total_pendings'];
               };
            };
         ?>
         <h3><?php echo $number_of_pendings; ?></h3>
         <p>Pending Job Posts</p>
      </div>


      <div class="box">
         <?php 
            $select_users = mysqli_query($conn, "SELECT count(*) as total_users from job_seeker WHERE account_type='job_seeker';") or die('query failed');
            $number_of_users = 0;
            if(mysqli_num_rows($select_users) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_users)){
                  $number_of_users = $fetch_users['total_users'];
               };
            };
         ?>
         <h3><?php echo $number_of_users; ?></h3>
         <p>Total Job Seekers</p>
      </div>

      <div class="box">
         <?php 
            $select_company = mysqli_query($conn, "SELECT Count(*) as total_companies FROM company;") or die('query failed');
            $number_of_companies = 0;
            if(mysqli_num_rows($select_company) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_company)){
                  $number_of_companies = $fetch_users['total_companies'];
               };
            };
         ?>
         <h3><?php echo $number_of_companies; ?></h3>
         <p>Total Companies</p>
      </div>

      <div class="box">
         <?php 
            
            $select_messages = mysqli_query($conn, "SELECT count(*) as total_messages from message;") or die('query failed');
            $number_of_messages = 0;
            if(mysqli_num_rows($select_messages) > 0){
               while($fetch_users = mysqli_fetch_assoc($select_messages)){
                  $number_of_messages = $fetch_users['total_messages'];
               };
            };
         ?>
         <h3><?php echo $number_of_messages; ?></h3>
         <p>Total Messages</p>
      </div>

      <div class="box">
         <?php
            $total_earned = 0;
            // Need to add the earned revenue
         ?>
         <h3><?php echo $total_earned; ?> TK</h3>
         <p>Total Revenue</p>
      </div>



   </div>

</section>

<!-- admin dashboard section ends -->









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>