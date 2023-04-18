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

<section class="courses">

   <h1 class="heading">Search Result</h1>

   <div class="box-container">

      
      <div class="box">
         <div class="tutor">
            <div>
               <h3>Search Aything</h3>
               <span></span>
            </div>
         </div>
      </div>

   </div>

</section>

<!-- courses section ends -->



<?php include 'company_footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>