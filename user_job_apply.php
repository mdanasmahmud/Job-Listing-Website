<?php

include 'config.php';

session_start();

$account_type = $_SESSION['account_type'];

if($account_type != 'job_seeker'){
   header('location:login.php');
}

if(isset($_POST['apply_job_button'])){


    $job_apply_id = $_GET['job_apply_id'];
    $userId = $_SESSION['user_id'];

    //This is for uploading the education documents
    $user_cv = $_FILES['user_cv_pdf']['name'];

    $user_cv_tmp_name = $_FILES['user_cv_pdf']['tmp_name'];
    $user_cv_folder = 'uploaded_img/user_cv/'.$user_cv;

    mysqli_query($conn, "INSERT INTO `job_application` (job_post_id,job_seeker_id,job_seeker_cv) VALUES('$job_apply_id','$userId', '$user_cv')") or die('query failed');
    
    move_uploaded_file($user_cv_tmp_name, $user_cv_folder);
    
    $message[] = 'Job Applied Successfully';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Job Apply</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/user_style.css">

</head>
<body>

<?php include 'user_header.php'; ?>

<!-- Job Detail section Starts -->

<section class="edit-job-form">
<!-- Check if the portfolio, is empty or not -->
   <?php
      if(isset($_GET['job_apply_id'])){
        $job_seeker_id = $_SESSION['user_id'];
        $test_query = mysqli_query($conn, "SELECT * FROM `job_seeker` WHERE id = '{$job_seeker_id}'") or die('query failed');
        $row = mysqli_fetch_assoc($test_query);
         if($row['portfolio'] == '' || $row['portfolio'] == null || $row['education_document'] == '' || $row['education_document'] == null || $row['nid_picture'] == '' || $row['nid_picture'] == null){
            echo '
            <h3>Portfolio, Student Document or NID is incomplete</h3>
            ';
         }else{
            $job_detail_id = $_GET['job_apply_id'];
         $update_query = mysqli_query($conn, "SELECT * FROM `job_seeker` WHERE id = '{$job_seeker_id}'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
      <form action="" method="post" enctype="multipart/form-data">
            <h3>This will be sent to the company</h3>

            <img src="uploaded_img/<?php echo $fetch_update['picture']; ?>" alt="">
            <p type="text" name="show_job_title" class="box" style="font-size: 24px; color: purple;">Name: <?php echo $fetch_update['name']; ?></p>
            <p type="text" name="show_job_title" class="box" style="font-size: 18px;">Email: <?php echo $fetch_update['email']; ?></p>
            <textarea type="text" name="show_job_description" cols="50" rows="15" class="box" disabled><?php echo $fetch_update['portfolio']; ?></textarea>
        <p style="font-size: 18px;">Upload your CV</p>
        <input type="file" name="user_cv_pdf" accept="document_pdf/pdf" class="box" required>

        <input type="submit" value="Apply" name="apply_job_button" class="btn"> 
        <input type="reset" value="cancel" id="close-update" class="option-btn" onclick="window.location = 'user_dashboard.php'">
      </form>

         <?php
         }
      }
         }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>
<!-- Job Detail section Ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>