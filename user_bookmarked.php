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
   <title>Bookmark</title>

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
         $select_book = mysqli_query($conn, "SELECT company.name AS company_name, company.email AS company_email, company.company_logo, company.company_details, bookmark.bookmark_date
         FROM bookmark
         JOIN company ON bookmark.bookmark_company = company.id
         JOIN job_seeker ON bookmark.bookmark_job_seeker = job_seeker.id WHERE bookmark.bookmark_job_seeker = '$display_user_id' ORDER BY bookmark_date desc") or die('query failed');
            
        
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_book)){
            ?>
         <form action="" method="post" class="box">
            <p><img src="uploaded_img/profile_img/<?php echo $fetch_products['company_logo']; ?>" alt="Company Picture" style="width: 150px; height: 200px;"></span> </p>
            <div class="title"><?php echo $fetch_products['company_name']; ?></div>
            <p>Email: <span><?php echo $fetch_products['company_email']; ?></span></p>
            <p>Company Details: <span></span></p>
            <br>
            <div class="box">
            <p><span><?php echo $fetch_products['company_details']; ?></span></p>
            </div>
        
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


<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>