<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'company'){
   header('location:login.php');
}

if(isset($_POST['update_job_post'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_salary = $_POST['update_salary'];

   // This is the product_details table
   $update_job_type = $_POST['update_job_type']; 
   $update_job_description = mysqli_real_escape_string($conn, $_POST['update_job_description']);
   $update_expiration_date = $_POST['update_expiration_date'];
   $update_job_category = $_POST['update_job_category'];

   mysqli_query($conn, "UPDATE `jobs_posted` SET job_title = '$update_name',
   job_details = '$update_job_description', job_type = '$update_job_type', job_category = '$update_job_category',
   job_salary = '$update_salary', job_expiration_date = '$update_expiration_date'
   WHERE job_id = '$update_p_id'") or die('query failed');
   
   $message[] = 'Updated the Job Post';

   header('location:company_dashboard.php');

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
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'company_header.php'; ?>

<!-- Company Status section starts  -->

<section class="quick-select">

   <h1 class="heading">Company Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <?php
         $company_id = $_SESSION['user_id'];
         $select_post = mysqli_query($conn, "SELECT *
                     FROM `job_application`
                     JOIN `jobs_posted` ON job_application.job_post_id = jobs_posted.job_id
                     JOIN `job_seeker` ON job_application.job_seeker_id = job_seeker.id WHERE job_company_id='$company_id'") or die('query failed');
         $total_applicants = mysqli_num_rows($select_post); // Counting the total number of applicants
         $latest_applicant = null;
         if($total_applicants > 0){
            $select_latest = mysqli_query($conn, "SELECT *
                     FROM `job_application`
                     JOIN `jobs_posted` ON job_application.job_post_id = jobs_posted.job_id
                     JOIN `job_seeker` ON job_application.job_seeker_id = job_seeker.id WHERE job_company_id='$company_id' ORDER BY application_id DESC LIMIT 1") or die('query failed');
         $latest_applicant = mysqli_fetch_assoc($select_latest); // Fetching the latest applicant

         }
         ?>
         <h3 class="title">Total Applicants: <?php echo $total_applicants ?></h3>
         <p>Recent Applicant: <span><?php if($latest_applicant == null){echo "No Applicant";} ?></span></p>
      </div>


      <div class="box">
         <?php
         $company_id = $_SESSION['user_id'];
         $select_post = mysqli_query($conn, "SELECT *
                     FROM `jobs_posted`
                     WHERE job_company_id='$company_id'") or die('query failed');
         $total_job_post = mysqli_num_rows($select_post); // Counting the total number of applicants
         $select_latest = mysqli_query($conn, "SELECT *
         FROM `jobs_posted`
         WHERE job_company_id='$company_id' ORDER BY job_creation_date DESC LIMIT 1") or die('query failed');
         $latest_job = mysqli_fetch_assoc($select_latest); // Fetching the latest applicant
         ?>
         <h3 class="title">Total Jobs Posted: <?php echo $total_job_post ?></h3>
         <p>Recent Job: <span><?php if($latest_job == null){echo "No Job Posts Yet";}else{echo $latest_job['job_title'];} ?></span></p>
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
         <p>Recent Message: <span><?php if($latest_applicant == null){echo "Got No Messages Yet";}else{echo $latest_applicant['name'];} ?></span></p>

         
      </div>
      


   </div>

</section>

<!-- Company status section ends -->

<!-- All jobs section Starts -->

<section class="quick-select">

   <h1 class="heading">Jobs Posted</h1>

   <div class="box-container">

      <?php
         $display_company_id = $_SESSION['user_id'];
         $select_book = mysqli_query($conn, "SELECT * FROM `jobs_posted` WHERE job_company_id='$display_company_id' ORDER BY job_creation_date desc") or die('query failed');
            
        
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_book)){
            ?>
         <form action="" method="post" class="box">

            <div class="title"><?php echo $fetch_products['job_title']; ?></div>
            <p>Job Post ID: <span><?php echo $fetch_products['job_id']; ?></span></p>
            
            <p>Job Salary: <span><?php echo $fetch_products['job_salary']; ?></span></p>

   

            <p>Job Expiration Date: <span><?php echo $fetch_products['job_expiration_date']; ?></span></p>
            <p>Job Status: <span><?php echo $fetch_products['job_post_status']; ?></span></p>
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['job_id']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['job_salary']; ?>">
            <a href="company_dashboard.php?update=<?php echo $fetch_products['job_id']; ?>" class="btn">Job Details</a>
         </form>
            <?php
               }
         }else{
            echo '<p class="empty">No Job Has Been Posted Yet!</p>';
         }
      ?>
      


   </div>

</section>

<!-- All jobs section Ends -->

<!-- Job Detail section Starts -->

<section class="edit-job-form">
         
   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `jobs_posted` WHERE job_id = '{$update_id}'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
   <h1 class='heading'>Job Details</h1>
      
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['job_id']; ?>">
      
      <input type="text" name="update_name" value="<?php echo $fetch_update['job_title']; ?>" class="box" required placeholder="Enter New Title">
      <input type="number" name="update_salary" value="<?php echo $fetch_update['job_salary']; ?>" min="0" class="box" required placeholder="Enter New Salary">
      <select name="update_job_type" class="box" required> 
         <option value="" selected disabled><?php echo $fetch_update['job_type']; ?></option>
         <option value="Full Time">Full Time</option>
         <option value="Part Time">Part Time</option>
      </select>
      <textarea type="text" name="update_job_description" cols="30" rows="10" class="box" required placeholder="Enter Job Description"><?php echo $fetch_update['job_details']; ?></textarea>

      <input type="date" name="update_expiration_date" value="<?php echo $fetch_update['job_expiration_date']; ?>" class="box" required placeholder="Edit Expiration Date">
      
      <select name="update_job_category" class="box" required>
         <option value="" selected disabled><?php echo $fetch_update['job_category']; ?></option>
         <option value="Teacher">Teacher</option>
         <option value="Engineer">Engineer</option>
         <option value="IT">IT</option>
         <option value="Marketing">Marketing</option>
         <option value="Customer Service">Customer Service</option>
         <option value="Medical">Medical</option>
         <option value="Manager">Manager</option>
         <option value="Data Entry">Data Entry</option>
         <option value="Accounting">Accounting</option>
         <option value="Bank">Bank</option>
         <option value="NGO">NGO</option>
         <option value="Others">Others</option>
      </select>

      <input type="submit" value="update" name="update_job_post" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'company_dashboard.php'">
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