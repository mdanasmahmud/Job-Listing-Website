<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'job_seeker'){
   header('location:login.php');
}

if(isset($_GET['company_id'])){
   $user_id = $_SESSION['user_id'];
   $company_id = $_GET['company_id'];
   $insert_message = mysqli_query($conn, "INSERT INTO bookmark (bookmark_company, bookmark_job_seeker) VALUES ('$company_id', '$user_id')") or die('query failed');
   $message[] = 'Bookmarked';
   
   header('location:user_bookmarked.php');

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Jobs</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3 style="color: white;">search page</h3>
   <p style="color: #ccc;"> <a href="home.php" >Home</a> / Search </p>
</div>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search" placeholder="search jobs, companies..." class="box">
      <input type="submit" name="submit" value="search" class="btn">
   </form>
</section>

<section class="show-products">

   <div class="box-container">
      <?php
         if(isset($_POST['submit'])){
            $search_item = $_POST['search'];
            $select_jobs = mysqli_query($conn, "SELECT * FROM `jobs_posted` 
                                    INNER JOIN `company` on jobs_posted.job_company_id = company.id 
                                    WHERE (job_title LIKE '%{$search_item}%' OR name LIKE '%{$search_item}%') 
                                    AND job_post_status = 'Approved'") or die('query failed');
            if(mysqli_num_rows($select_jobs) > 0){
            while($fetch_job = mysqli_fetch_assoc($select_jobs)){
      ?>

      <form action="" method="post" class="box">
         <p> <span class="details" style="font-size: 19px; color: green;"><span><?php echo $fetch_job['job_creation_date']; ?></span> </p>
         
         <div class="job_title"><a href="search_jobs.php?update=<?php echo $fetch_job['job_id']; ?>"><?php echo $fetch_job['job_title']; ?></a></div>
            <div class="company_name"><?php echo $fetch_job['name']; ?></div>
            <br>

            <div class="box">
               <div class="job_details"><?php echo (strlen($fetch_job['job_details']) > 70) ? substr($fetch_job['job_details'],0,30).'...' : $fetch_job['job_details']; ?></div>
            </div>
         </form>
      <?php
               }
            }else{
               echo '<p class="empty">Unable To Find The Job</p>';
            }
         }else{
            echo '<p class="empty">Search Any Job Postings</p>';
         }
      ?>
   </div>

</section>

<style>
.box p { position: relative; }
.box .details { position: absolute; top: 0; right: 0; }
</style>


<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $job_detail_id = $_GET['update'];
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
            <p type="text" name="show_job_title" class="box" style="font-size: 18px;">Job Post Expiration: <?php echo $fetch_update['job_expiration_date']; ?></p>

         <?php
         ?>
         <a href="user_job_apply.php?job_apply_id=<?php echo $fetch_update['job_id']; ?>" class="btn" style="background-color: green;">Apply Job</a>
         <a class="btn" href="search_jobs.php?company_id=<?php echo $fetch_update['id']; ?>&job_title=<?php echo urlencode($fetch_update['job_title']); ?>">Bookmark</a>
         <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'search_jobs.php'">
      </form>

         <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>

<!-- custom js file link  -->
<script src="js/script.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>