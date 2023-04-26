<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'company'){
   header('location:login.php');
}

if(isset($_POST['update_company_profile'])){

    $update_p_id = $_POST['update_p_id'];

    $update_name = $_POST['update_name'];
    $update_email = $_POST['update_email'];

    $update_company_description = $_POST['update_company_description'];

    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    // This is for uploading logo
    $profile_image = $_FILES['profile_image']['name'];

    $profile_image_tmp_name = $_FILES['profile_image']['tmp_name'];
    $profile_image_folder = 'uploaded_img/profile_img/'.$profile_image;

    // This is for uploading document pdf
    $company_document = $_FILES['document_pdf']['name'];

    $company_document_tmp_name = $_FILES['document_pdf']['tmp_name'];
    $company_document_folder = 'uploaded_img/company_document/'.$company_document;

    $select_users = mysqli_query($conn, "SELECT * FROM `company` WHERE email = '$update_email' AND password = '$pass'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        
        if($pass != $cpass){
            $message[] = 'Confirm Password Does Not Match';
         }else{
            mysqli_query($conn, "UPDATE `company` SET name = '$update_name',
            email = '$update_email', password = '$pass', company_details = '$update_company_description',
            company_logo = '$profile_image', company_document = '$company_document'
            WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($profile_image_tmp_name, $profile_image_folder);
            move_uploaded_file($company_document_tmp_name, $company_document_folder);
            $message[] = 'Company Profile Has Been Edited Successfully';
         }
     }else{
        $message[] = 'Password Incorrect';
        
     }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Company Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'company_header.php'; ?>


<!-- Job Detail section Starts -->

<section class="edit-job-form">
         
   <?php
         $update_id = $_SESSION['user_id'];
         $update_query = mysqli_query($conn, "SELECT * FROM `company` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
   <h1 class='heading'>Company Profile Edit</h1>
      
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <p style="font-size: 19px; text-align: left;">Edit Company Name</p>
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Edit Company Name">
      <p style="font-size: 19px; text-align: left;">Edit Company Email</p>
      <input type="text" name="update_email" value="<?php echo $fetch_update['email']; ?>" class="box" required placeholder="Edit Company Email">
      <p style="font-size: 19px; text-align: left;">Upload Your Company's Logo</p>
      <input type="file" name="profile_image" accept="profile_image/jpg, profile_image/jpeg, profile_image/png" class="box" required>
      
      <p style="font-size: 19px; text-align: left;">Upload Company Documents as PDF</p>
      <input type="file" name="document_pdf" accept="document_pdf/pdf" class="box" required>

      <p style="font-size: 19px; text-align: left;">Edit Description</p>
      <textarea type="text" name="update_company_description" cols="30" rows="10" class="box" required placeholder="Enter Company Description"><?php echo $fetch_update['company_details']; ?></textarea>
      
      <input type="password" name="password" placeholder="Enter Password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm Password" required class="box">

      <input type="submit" value="update" name="update_company_profile" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'company_dashboard.php'">
   </form>
   <?php
         }
      }
      
   ?>

</section>
<!-- Job Detail section Ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>