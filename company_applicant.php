<?php

include 'config.php';

session_start();


$account_type = $_SESSION['account_type'];

if($account_type != 'company'){
   header('location:login.php');
}

if(isset($_POST['update_application_status'])){

   $application_id = $_POST['application_id'];
   $update_status = $_POST['update_status'];
   mysqli_query($conn, "UPDATE `job_application` SET application_status = '$update_status' WHERE application_id = '$application_id'") or die('query failed');
   $message[] = 'Application status changed to ' . $update_status;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Job Applicants</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'company_header.php'; ?>

<!-- quick select section starts  -->

<section class="quick-select">

   <h1 class="heading">Job Application</h1>

   <div class="box-container">

      <!-- <div class="box">
         <h3 class="title">Total Applicants</h3>
         <p>Recent Applicant: <span></span></p>
         <a href="applicants.php" class="inline-btn">view applicants</a>

         
      </div> -->

      <?php
      $company_id = $_SESSION['user_id'];
      $select_post = mysqli_query($conn, "SELECT *
      FROM `job_application`
      JOIN `jobs_posted` ON job_application.job_post_id = jobs_posted.job_id
      JOIN `job_seeker` ON job_application.job_seeker_id = job_seeker.id WHERE job_company_id='$company_id'") or die('query failed');
      if(mysqli_num_rows($select_post) > 0){
         while($fetch_job = mysqli_fetch_assoc($select_post)){
      ?>
      <div class="box">
         <p><img src="uploaded_img/profile_img/<?php echo $fetch_job['picture']; ?>" alt="Job Seeker Picture" style="width: 150px; height: 200px;"></span> </p>
         <p> Application ID : <span><?php echo $fetch_job['application_id']; ?></span> </p>
         <p> Job Post ID : <span><?php echo $fetch_job['job_post_id']; ?></span> </p>
         <p> Job Title : <span><?php echo $fetch_job['job_title']; ?></span> </p>
         <p> Applicant Name : <span><?php echo $fetch_job['name']; ?></span> </p>
         <p> Applicant Email : <span><?php echo $fetch_job['email']; ?></span> </p>
         <p> Job Seeker CV: <a href="uploaded_img/user_cv/<?php echo urlencode($fetch_job['job_seeker_cv']); ?>" target="_blank"><?php echo $fetch_job['job_seeker_cv']; ?></a> </p>
         <p> Application Date : <span><?php echo $fetch_job['job_application_date']; ?></span> </p>


         <form action="" method="post">
            <input type="hidden" name="application_id" value="<?php echo $fetch_job['application_id']; ?>">
            <select name="update_status">
               <option value="" selected disabled><?php echo $fetch_job['application_status']; ?></option>
               <option value="Approve">Approve</option>
               <option value="Reject">Reject</option>
            </select>
            <input type="submit" value="Update" name="update_application_status" class="option-btn">
            <a href="admin_job_posts.php?delete=<?php echo $fetch_job['id']; ?>" onclick="return confirm('delete this job post?');" class="delete-btn">delete</a>
         </form>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No Job Posts Yet</p>';
      }
      ?>


   </div>

</section>

<!-- quick select section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>