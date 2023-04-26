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
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `company` WHERE email = '$email'") or die('query failed');

   // This is for uploading logo
   $profile_image = $_FILES['profile_image']['name'];

   $profile_image_tmp_name = $_FILES['profile_image']['tmp_name'];
   $profile_image_folder = 'uploaded_img/profile_img/'.$profile_image;

   // This is for uploading document pdf
   $company_document = $_FILES['document_pdf']['name'];

   $company_document_tmp_name = $_FILES['document_pdf']['tmp_name'];
   $company_document_folder = 'uploaded_img/company_document/'.$company_document;

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'Company with this email already exists';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `company`(name, email, password, account_type, company_logo, company_document) VALUES('$name', '$email', '$cpass', '$user_type', '$profile_image', '$company_document')") or die('query failed');
         move_uploaded_file($profile_image_tmp_name, $profile_image_folder);
         move_uploaded_file($company_document_tmp_name, $company_document_folder);
         $message[] = 'Company account has been registered successfully';
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
   <title>Register Company</title>

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
      <h3>Register Your Company</h3>
      <input type="text" name="name" placeholder="Enter Company Name" required class="box">
      <input type="email" name="email" placeholder="Enter Company Email" required class="box">
      <input type="password" name="password" placeholder="Enter Password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm Password" required class="box">

      <p>Upload Your Company's Logo</p>
      <input type="file" name="profile_image" accept="profile_image/jpg, profile_image/jpeg, profile_image/png" class="box" required>
      <p>Upload Company Documents as PDF</p>
      <input type="file" name="document_pdf" accept="document_pdf/pdf" class="box" required>

      <p>User Type</p>
      <select name="user_type" class="box">
         <option value="company">Company</option>
      </select>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>Already have an account? <a href="login.php">Login Now</a></p>
   </form>

</div>

</body>
</html>