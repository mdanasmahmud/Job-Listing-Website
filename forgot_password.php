<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $security_answer = mysqli_real_escape_string($conn, md5($_POST['security_answer']));
   $new_password = mysqli_real_escape_string($conn, md5($_POST['new_password']));
   $user_type = $_POST['user_type'];

   if($user_type == 'job_seeker' || $user_type == 'admin'){
      $select_users = mysqli_query($conn, "SELECT * FROM `job_seeker` WHERE email = '$email' AND security_answer = '$security_answer'") or die('query failed');
      if(mysqli_num_rows($select_users) > 0){

        mysqli_query($conn, "UPDATE `job_seeker` SET password = '$new_password' WHERE email = '$email'") or die('query failed');}
   }

   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Forgot Password</title>

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
      <h3>Reset Password</h3>
      <input type="email" name="email" placeholder="Enter Your Email" required class="box">
      <input type="name" name="security_answer" placeholder="Enter Security Answer" required class="box">
      <input type="password" name="new_password" placeholder="Enter New Password" required class="box">

      <select name="user_type" class="box">
         <option value="job_seeker">Job Seeker</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Reset" class="btn">
      <p>Remembered Password? <a href="login.php">Login Now</a></p>
      <p>Don't have an account? <a href="register_type.php">Register Now</a></p>
   </form>

</div>

</body>
</html>