<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'job_seeker'){
   header('location:login.php');
}

if(isset($_POST['update_user_profile'])){

    $update_p_id = $_POST['update_p_id'];

    $update_name = $_POST['update_name'];
    $update_email = $_POST['update_email'];

    $update_user_description = $_POST['update_user_description'];

    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    // This is for uploading picture
    $profile_image = $_FILES['profile_image']['name'];

    $profile_image_tmp_name = $_FILES['profile_image']['tmp_name'];
    $profile_image_folder = 'uploaded_img/profile_img/'.$profile_image;

    // This is for uploading NID
    $nid_image = $_FILES['nid_image']['name'];

    $nid_image_tmp_name = $_FILES['nid_image']['tmp_name'];
    $nid_image_folder = 'uploaded_img/nid_img/'.$profile_image;

    //This is for uploading the education documents
    $user_document = $_FILES['document_pdf']['name'];

    $user_document_tmp_name = $_FILES['document_pdf']['tmp_name'];
    $user_document_folder = 'uploaded_img/user_document/'.$user_document;

    $select_users = mysqli_query($conn, "SELECT * FROM `job_seeker` WHERE email = '$update_email' AND password = '$pass'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        
        if($pass != $cpass){
            $message[] = 'Confirm Password Does Not Match';
         }else{
            mysqli_query($conn, "UPDATE `job_seeker` SET name = '$update_name',
            email = '$update_email', password = '$pass', portfolio = '$update_user_description',
            picture = '$profile_image', nid_picture = '$nid_image', education_document = '$user_document'
            WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($profile_image_tmp_name, $profile_image_folder);
            move_uploaded_file($nid_image_tmp_name, $nid_image_folder);
            move_uploaded_file($user_document_tmp_name, $user_document_folder);
            $message[] = 'User Profile Has Been Edited Successfully';
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
   <title>User Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'user_header.php'; ?>


<!-- Job Detail section Starts -->

<section class="edit-job-form">
         
   <?php
         $update_id = $_SESSION['user_id'];
         $update_query = mysqli_query($conn, "SELECT * FROM `job_seeker` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
   <h1 class='heading'>Job Seeker Profile Edit</h1>
      
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <p style="font-size: 19px; text-align: left;">Edit User Name</p>
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Edit User Name">
      <p style="font-size: 19px; text-align: left;">Edit User Email</p>
      <input type="text" name="update_email" value="<?php echo $fetch_update['email']; ?>" class="box" required placeholder="Edit User Email">

      <p style="font-size: 19px; text-align: left;">Upload NID</p>
      <input type="file" name="nid_image" accept="nid_image/jpg, nid_image/jpeg, nid_image/png" class="box" required>

      <p style="font-size: 19px; text-align: left;">Upload Your Picture</p>
      <input type="file" name="profile_image" accept="profile_image/jpg, profile_image/jpeg, profile_image/png" class="box" required>

      <p style="font-size: 19px; text-align: left;">User Portfolio</p>
      <textarea type="text" name="update_user_description" cols="30" rows="30" class="box" maxlength="3000" placeholder="Enter User Portfolio"><?php echo $fetch_update['portfolio']; ?></textarea>
      
      <p style="font-size: 19px; text-align: left;">Upload User Education Dcouments as PDF</p>
      <input type="file" name="document_pdf" accept="document_pdf/pdf" class="box" required>

      <input type="password" name="password" placeholder="Enter Password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm Password" required class="box">

      <input type="submit" value="update" name="update_user_profile" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'user_dashboard.php'">
   </form>
   <?php
         }
      }
      
   ?>

</section>
<!-- Job Detail section Ends -->

<!-- custom js file link  -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="js/script.js"></script>

</body>
</html>