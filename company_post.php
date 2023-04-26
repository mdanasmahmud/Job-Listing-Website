<?php

include 'config.php';

session_start();


$account_type = $_SESSION['account_type'];

if($account_type != 'company'){
   header('location:login.php');
}

if(isset($_POST['add_job_button'])){
   
   $title = mysqli_real_escape_string($conn, $_POST['title']);
   $salary = $_POST['salary'];

   date_default_timezone_set('Asia/Dhaka');
   $job_creation_date = date('Y/m/d h:i:s a', time());

   $company_id = $_SESSION['user_id'];
   $job_status = 'Pending';


   $job_description = mysqli_real_escape_string($conn, $_POST['job_description']);
   $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);

   $job_expiration_date = mysqli_real_escape_string($conn, $_POST['job_expiration_date']);
   $job_category = mysqli_real_escape_string($conn, $_POST['job_category']);

   // This is the job insertion code
   
   $add_job_post_query = mysqli_query($conn, "INSERT INTO `jobs_posted`(job_title,job_company_id,job_details, job_type, job_category, job_salary, job_creation_date, job_expiration_date, job_post_status) VALUES('$title','$company_id','$job_description', '$job_type', '$job_category','$salary', '$job_creation_date', '$job_expiration_date', '$job_status')") or die('query failed');

   $message[] = 'Job Post Has Been Added, Admin needs to approve it';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Company Job Post</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'company_header.php'; ?>

<!-- quick select section starts  -->

<section class="add-products">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Post A Job</h3>
      <input type="text" name="title" class="box" placeholder="Enter Job Title" required>
      <input type="number" min="0" name="salary" class="box" placeholder="Enter Job Salary" required>
      
      <textarea type="text" name="job_description" class="box" placeholder="Enter Job Description" cols="30" rows="10" required></textarea>
      
      <select name="job_type" class="box" required> 
         <option value="Full Time">Full Time</option>
         <option value="Part Time">Part Time</option>
      </select>
      <p style="font-size: 16px; text-align: left;">Post Expire Date:</p>
      <input type="date" name="job_expiration_date" class="box" placeholder="Publication Date" required>
      
      <select name="job_category" class="box" required> 
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

      <?php
      $current_company = $_SESSION['user_id'];

      $sql = "SELECT COUNT(*) as num_rows FROM jobs_posted WHERE job_company_id = '$current_company'";
      $result = mysqli_query($conn, $sql);

      if ($result && mysqli_num_rows($result) > 0) {

         $row = mysqli_fetch_assoc($result);
         $num_rows = $row['num_rows'];

         if ($num_rows >= 3) {
            echo '<p style="font-size: 16px; text-align: left;">Bkash Number: 01302542233</p>';
            echo '<input type="text" name="bkash_transaction" class="box" placeholder="Bkash Transaction" required>';
         }
      }
      ?>


      <input type="submit" value="Post Job" name="add_job_button" class="btn">
   </form>

</section>

<!-- quick select section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>