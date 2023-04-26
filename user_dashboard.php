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
   <title>User Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'user_header.php'; ?>

<!-- User Status section starts  -->

<section class="quick-select">

   <h1 class="heading">User Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
         $user_id = $_SESSION['user_id'];
         $select_post = mysqli_query($conn, "SELECT *
                     FROM `job_application`
                     JOIN `jobs_posted` ON job_application.job_post_id = jobs_posted.job_id
                     WHERE job_seeker_id='$user_id'") or die('query failed');
         $total_applicants = mysqli_num_rows($select_post); // Counting the total number of applicants
         $latest_applicant = null;
         
         if($total_applicants > 0){
            $select_latest = mysqli_query($conn, "SELECT *
                     FROM `job_application`
                     JOIN `jobs_posted` ON job_application.job_post_id = jobs_posted.job_id
                     WHERE job_seeker_id='$user_id' ORDER BY job_application_date DESC LIMIT 1") or die('query failed');
         $latest_applicant = mysqli_fetch_assoc($select_latest); // Fetching the latest applicant

         }
         ?>
         <h3 class="title">Total Applied: <?php echo $total_applicants ?></h3>
         <p>Recent Apply: <span><?php if($latest_applicant == null){echo "Not Applied Yet";}else{echo $latest_applicant['job_title'];} ?></span></p>
      </div>

      <div class="box">
      <?php
         $user_id = $_SESSION['user_id'];
         $select_post = mysqli_query($conn, "SELECT DISTINCT message_sender_id
                     FROM `message`
                     WHERE message_receiver_id='$user_id'") or die('query failed');
         $total_applicants = mysqli_num_rows($select_post); // Counting the total number of applicants
         $latest_applicant = null;
         
         if($total_applicants > 0){
            $select_latest = mysqli_query($conn, "SELECT *
                     FROM `message`
                     JOIN `company` ON message.message_sender_id = company.id
                     WHERE message_receiver_id='$user_id' ORDER BY message_time DESC LIMIT 1") or die('query failed');
         $latest_applicant = mysqli_fetch_assoc($select_latest); // Fetching the latest applicant

         }
         ?>
         <h3 class="title">Total Messages: <?php echo $total_applicants ?></h3>
         <p>Recent Message: <span><?php if($latest_applicant == null){echo "No Messages Yet";}else{echo $latest_applicant['name'];} ?></span></p>

         
      </div>
      


   </div>

</section>

<!-- User status section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>