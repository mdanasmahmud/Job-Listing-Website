<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'admin'){
   header('location:login.php');
}

if(isset($_POST['update_job'])){

   $job_update_id = $_POST['job_id'];
   $update_status = $_POST['update_status'];
   mysqli_query($conn, "UPDATE `jobs_posted` SET job_post_status = '$update_status' WHERE job_id = '$job_update_id'") or die('query failed');
   $message[] = 'Job Post Has Been Approved';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `jobs_posted` WHERE job_id = '$delete_id'") or die('query failed');
   header('location:admin_job_posts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Job Posted</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">

   <h1 class="title">Job Posts By The Company</h1>

   <div class="box-container">
      <?php
      $select_post = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id") or die('query failed');
      if(mysqli_num_rows($select_post) > 0){
         while($fetch_job = mysqli_fetch_assoc($select_post)){
      ?>
      <div class="box">
         <p> Company Name : <span><?php echo $fetch_job['name']; ?></span> </p>
         <p> Placed On : <span><?php echo $fetch_job['job_creation_date']; ?></span> </p>
         <p> Job Title : <span><?php echo $fetch_job['job_title']; ?></span> </p>
         <p> Job Category : <span><?php echo $fetch_job['job_category']; ?></span> </p>
         <p> Job Salary : <span><?php echo $fetch_job['job_salary']; ?></span> </p>
         <p> Job Details : <span><?php echo $fetch_job['job_details']; ?></span> </p>
         <p> Job Expires On : <span><?php echo $fetch_job['job_expiration_date']; ?></span> </p>

         <?php
         $company_id = $fetch_job['id'];

         $sql = "SELECT COUNT(*) as num_rows FROM jobs_posted WHERE job_company_id = '$company_id'";
         $result = mysqli_query($conn, $sql);

         if ($result && mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);
            $num_rows = $row['num_rows'];

            if ($num_rows >= 3) {
               echo '<p>Bkash Transaction: <span style="font-weight: bold;">' . $fetch_job['bkash_transaction'] . '</span></p>';
            }
         }
         ?>


         <form action="" method="post">
            <input type="hidden" name="job_id" value="<?php echo $fetch_job['job_id']; ?>">
            <select name="update_status">
               <option value="" selected disabled><?php echo $fetch_job['job_post_status']; ?></option>
               <option value="Pending">Pending</option>
               <option value="Reject">Reject</option>
               <option value="Approved">Approved</option>
            </select>
            <input type="submit" value="update" name="update_job" class="option-btn">
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










<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>