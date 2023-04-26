<?php


if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}


include 'config.php';
session_start();

// Delete accounts that does not have does not have NID and is 7 days old

// Get the current date and time
$current_date = date('Y-m-d');

// Subtract 7 days from the current date
$delete_date = date('Y-m-d', strtotime('-7 days', strtotime($current_date)));

// SQL query to delete rows that have nothing in nid_picture and are 7 days old
mysqli_query($conn, "DELETE FROM job_seeker WHERE nid_picture IS NULL AND account_creation_date <= '$delete_date'") or die('query failed');

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = 0;

   $select_users = mysqli_query($conn, "SELECT * FROM `job_seeker` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) <= 0){
      $select_users = mysqli_query($conn, "SELECT * FROM `company` WHERE email = '$email' AND password = '$pass'") or die('query failed');
   }


   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['account_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         $_SESSION['account_type'] = $row['account_type'];
         header('location:admin_page.php');

      }
      elseif($row['account_type'] == 'job_seeker'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         $_SESSION['account_type'] = $row['account_type'];
         header('location:home.php');

      }
      elseif($row['account_type'] == 'company'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         $_SESSION['account_type'] = $row['account_type'];
         header('location:company_dashboard.php');

   }

}else{
   $message[] = 'Email or password is incorrect';
}

}?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" placeholder="Enter Your Email" required class="box">
      <input type="password" name="password" placeholder="Enter Your Password" required class="box">
      <input type="submit" name="submit" value="Login Now" class="btn">
      <p>Can't remember your password? <a href="forgot_password.php">Reset Now</a></p>
      <p>Don't have an account? <a href="register_type.php">Register Now</a></p>
   </form>

</div>

</body>
</html>