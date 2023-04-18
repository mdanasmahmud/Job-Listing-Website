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
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>search page</h3>
   <p> <a href="home.php">Home</a> / Search </p>
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
            $select_jobs = mysqli_query($conn, "SELECT * FROM `jobs_posted` INNER JOIN `company` on jobs_posted.job_company_id = company.id WHERE job_title LIKE '%{$search_item}%' OR name LIKE '%{$search_item}%'") or die('query failed');
            if(mysqli_num_rows($select_jobs) > 0){
            while($fetch_job = mysqli_fetch_assoc($select_jobs)){
      ?>

      <form action="" method="post" class="box">
         <div class="price"><?php echo $fetch_job['job_title']; ?></div>
         <div class="name"><?php echo $fetch_job['job_type']; ?></div>
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




<!-- custom js file link  -->
<script src="js/script.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>