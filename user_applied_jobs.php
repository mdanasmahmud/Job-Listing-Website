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
   <title>User Applied Jobs</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'user_header.php'; ?>

<!-- All jobs section Starts -->

<section class="quick-select">

   <h1 class="heading">Jobs Posted</h1>

   <div class="box-container">

      <?php
         $display_user_id = $_SESSION['user_id'];
         $select_book = mysqli_query($conn, "SELECT job_application.*, jobs_posted.*, company.*
         FROM job_application
         JOIN jobs_posted ON job_application.job_post_id = jobs_posted.job_id
         JOIN company ON jobs_posted.job_company_id = company.id WHERE job_application.job_seeker_id = '$display_user_id'") or die('query failed');
            
        
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_book)){
            ?>
         <form action="" method="post" class="box">

            <div class="title"><?php echo $fetch_products['job_title']; ?></div>
            <p>Company: <span><?php echo $fetch_products['name']; ?></span></p>
            <p>Job Post ID: <span><?php echo $fetch_products['job_id']; ?></span></p>
            <p>Job Salary: <span><?php echo $fetch_products['job_salary']; ?></span></p>


            <p>Job Applied On: <span><?php echo $fetch_products['job_expiration_date']; ?></span></p>
            <p>Application Status: <span><?php echo $fetch_products['application_status']; ?></span></p>
            <a href="user_applied_jobs.php?user_job=<?php echo $fetch_products['job_id']; ?>" class="btn">Job Details</a>
         </form>
            <?php
               }
         }else{
            echo '<p class="empty">You have not applied to any jobs yet</p>';
         }
      ?>
      


   </div>

</section>

<!-- All jobs section Ends -->

<!-- Job Detail section Starts -->

<section class="edit-job-form">

   <?php
      if(isset($_GET['user_job'])){
         $job_detail_id = $_GET['user_job'];
         $update_query = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_id = '{$job_detail_id}'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
      <form action="" method="post" enctype="multipart/form-data">

            <img src="uploaded_img/<?php echo $fetch_update['company_logo']; ?>" alt="">
            <p type="text" name="show_job_title" class="box" style="font-size: 24px; color: purple;"><?php echo $fetch_update['job_title']; ?></p>
            <p type="text" name="show_job_title" class="box" style="font-size: 24px; color: red;"><?php echo $fetch_update['name']; ?></p>
            <p type="text" name="show_job_title" class="box" style="font-size: 18px;"><?php echo $fetch_update['job_type']; ?></p>
            <textarea type="text" name="show_job_description" cols="50" rows="15" class="box" disabled><?php echo $fetch_update['job_details']; ?></textarea>
            <p type="text" name="show_job_title" class="box" style="font-size: 18px;">Job Category: <?php echo $fetch_update['job_category']; ?></p>

      

         <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'user_applied_jobs.php'">
      </form>

         <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>
<!-- Job Detail section Ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>