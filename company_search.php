<?php

include 'config.php';

session_start();


$account_type = $_SESSION['account_type'];

if($account_type != 'company'){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users List</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'company_header.php'; ?>

<!-- courses section starts  -->

<section class="search-form">
<h1 class="heading">Search Any User</h1>
   <form action="" method="post">
      <input type="text" name="search" placeholder="search jobs, companies..." class="box">
      <input type="submit" name="submit" value="search" class="btn">
   </form>
</section>

<section class="courses">

   <div class="box-container">

      
      

      <?php
         if(isset($_POST['submit'])){
            $search_item = $_POST['search'];
            $select_jobs = mysqli_query($conn, "SELECT * FROM `job_seeker` WHERE name LIKE '%{$search_item}%'") or die('query failed');
            if(mysqli_num_rows($select_jobs) > 0){
            while($fetch_job = mysqli_fetch_assoc($select_jobs)){
      ?>

      <div class="box">
         <div class="tutor">
            <div>
               <h3>Name: <?= $fetch_job['name']; ?></h3>
               <span>Email: <?= $fetch_job['email']; ?></span>
            </div>
         </div>
      </div>


      <form action="" method="post" class="box" hidden>
         <div class="price"><?php echo $fetch_job['name']; ?></div>
         <div class="name"><?php echo $fetch_job['email']; ?></div>
      </form>
      <?php
               }
            }else{
               echo '<p class="empty">Unable To Find The User</p>';
            }
         }else{
            echo '<p class="empty">Search Any User</p>';
         }
      ?>

   </div>

</section>

<!-- courses section ends -->



<?php include 'company_footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>