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
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Vacant Jobs</h3>
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
         $select_jobs = mysqli_query($conn, "SELECT jobs_posted.job_title, company.name, jobs_posted.job_id
         FROM `jobs_posted`
         INNER JOIN `company` ON jobs_posted.job_company_id = company.id
         LIMIT 3") or die('query failed');
         if(mysqli_num_rows($select_jobs) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_jobs)){
      ?>
      
     <form action="" method="post" class="box">
      
      <div class="qty"><a href="home.php?update=<?php echo $fetch_products['job_id']; ?>"><?php echo $fetch_products['job_title']; ?><br></div>
      
      <div class="price"><?php echo $fetch_products['name']; ?></div>
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
      </div>

   </div>

</section>

<section class="home-contact">
  <div class="content">
    <h3>have any questions?</h3>
    <p>You can send us a mail</p>
  </div>
   </section>

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

      
         <a href="user_job_apply.php?job_apply_id=<?php echo $fetch_update['job_id']; ?>" class="btn" style="background-color: green;">Apply Job</a>
         <a class="btn" href="search_jobs.php?company_id=<?php echo $fetch_update['id']; ?>&job_title=<?php echo urlencode($fetch_update['job_title']); ?>">Bookmark</a>
         <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'home.php'">
      </form>

         <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>




<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>