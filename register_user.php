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

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $s_answer = mysqli_real_escape_string($conn, md5($_POST['security_answer']));
   $user_type = $_POST['user_type'];

   // This is for uploading profile picture
   $profile_image = $_FILES['profile_image']['name'];
   $profile_image_size = $_FILES['profile_image']['size'];
   $profile_image_tmp_name = $_FILES['profile_image']['tmp_name'];
   $profile_image_folder = 'uploaded_img/profile_img/'.$profile_image;

   // This is for uploading NID picture
   $nid_image = $_FILES['nid_image']['name'];
   $nid_image_size = $_FILES['nid_image']['size'];
   $nid_image_tmp_name = $_FILES['nid_image']['tmp_name'];
   $nid_image_folder = 'uploaded_img/nid_img/'.$nid_image;

   $select_users = mysqli_query($conn, "SELECT * FROM `job_seeker` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `job_seeker`(name, email, password, security_answer, account_type, picture, nid_picture) VALUES('$name', '$email', '$cpass','$s_answer', '$user_type', '$profile_image', '$nid_image')") or die('query failed');
         $message[] = 'registered successfully!';
         move_uploaded_file($profile_image_tmp_name, $profile_image_folder);
         move_uploaded_file($nid_image_tmp_name, $nid_image_folder);
         header('location:login.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register User</title>

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

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Register User</h3>
      <input type="text" name="name" placeholder="Enter Your Name" required class="box">
      <input type="email" name="email" placeholder="Enter Your Email" required class="box">
      <input type="password" name="password" placeholder="Enter Your Password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm Your Password" required class="box">
      
      <p>Upload Your Profile Picture (Optional)</p>
      <input type="file" name="profile_image" accept="profile_image/jpg, profile_image/jpeg, profile_image/png" class="box">
      <p>Upload Your NID (Optional but 7 Days To Upload)</p>
      <input type="file" name="nid_image" accept="nid_image/jpg, nid_image/jpeg, nid_image/png" class="box">
      
      <p>Who is the most important person to you?</p>
      <input type="text" name="security_answer" placeholder="Enter Security Answer" required class="box">
      <p>User Type</p>
      <select name="user_type" class="box">
         <option value="job_seeker">Job Seeker</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>Already have an account? <a href="login.php">Login Now</a></p>
   </form>

</div>

</body>
</html>