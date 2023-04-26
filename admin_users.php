<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'admin'){
   header('location:login.php');
}
$session_type = 0;

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   // There is a bug where it can only delete the company
   echo "<script>console.log('" . $session_type . "');</script>";

   if ($_SESSION['user_type_list'] == 'job_seeker') {
      mysqli_query($conn, "DELETE FROM `job_seeker` WHERE id = '$delete_id'") or die('query failed');
   }
   else if ($_SESSION['user_type_list'] == 'company'){
      mysqli_query($conn, "DELETE FROM `company` WHERE id = '$delete_id'") or die('query failed');
      
   }
   else if ($_SESSION['user_type_list'] == 'admin'){
      mysqli_query($conn, "DELETE FROM `job_seeker` WHERE id = '$delete_id'") or die('query failed');
   }
   
   
   // header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin User</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title"> user accounts </h1>

   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, "SELECT id, name, email, account_type from job_seeker UNION ALL SELECT id, name, email, account_type from company") or die('query failed');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="box">
         <p> User ID : <span><?php echo $fetch_users['id']; ?></span> </p>
         <p> Username : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> Email : <span><?php echo $fetch_users['email']; ?></span> </p>
         <p> User Type : <span style="color:<?php if($fetch_users['account_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['account_type']; 
         $_SESSION['user_type_list'] = $fetch_users['account_type'];
         // echo "<script>console.log('" . $session_type . "');</script>";
         ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete user</a>
      </div>
      <?php
         };
      ?>
   </div>

   

</section>



<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>