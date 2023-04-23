<?php

include 'config.php';

session_start();


$account_type = $_SESSION['account_type'];

if($account_type != 'company'){
   header('location:login.php');
}


if (isset($_GET['job_seeker_id'])) {
    header('Location: /cse471_job_listing/company_message_details.php');
 
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Messages</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'company_header.php'; ?>

<!-- quick select section starts  -->

<section class="quick-select">

   <h1 class="heading">All Messages</h1>

   <div class="box-container">
      <?php
      $company_id = $_SESSION['user_id'];
      $select_post = mysqli_query($conn, "SELECT job_seeker.name AS job_seeker_name, max(message.message_time) AS message_time, job_seeker.id AS job_seeker_id
      FROM message
      JOIN company ON message.message_sender_id = company.id
      JOIN job_seeker ON message.message_receiver_id = job_seeker.id 
      WHERE message.message_sender_id = '$company_id'
      GROUP BY job_seeker.name
      ORDER BY message_time ASC") or die('query failed');
      if(mysqli_num_rows($select_post) > 0){
         while($fetch_job = mysqli_fetch_assoc($select_post)){
      ?>
      <div class="box">
        <a href="company_message_details.php?job_seeker_id=<?php echo $fetch_job['job_seeker_id']; ?>"><p> Job Seeker Name : <span><?php echo $fetch_job['job_seeker_name']; ?></span> </p></a>
        
         
        <p> Latest Message : <span><?php echo $fetch_job['message_time']; ?></span> </p>
        
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No Messages To Show</p>';
      }
      ?>


   </div>

</section>

<!-- quick select section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>