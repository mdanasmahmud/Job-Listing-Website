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
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'company_header.php'; ?>

<!-- quick select section starts  -->

<section class="quick-select">

   <h1 class="heading">Company Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3 class="title">Total Applicants</h3>
         <p>Recent Applicant: <span></span></p>
         <!-- <a href="applicants.php" class="inline-btn">view applicants</a> -->

         
      </div>

      <div class="box">
         <h3 class="title">Total Jobs Posted</h3>
         <p>Recent Job: <span></span></p>

         
      </div>

      <div class="box">
         <h3 class="title">Total Messages</h3>
         <p>Recent Message: <span></span></p>

         
      </div>


   </div>

</section>

<!-- quick select section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>