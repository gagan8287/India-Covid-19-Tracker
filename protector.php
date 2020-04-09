<?php
$Password = 'ravinderaakash'; // Set your password here

if (isset($_POST['submit_pwd'])){
   $pass = isset($_POST['passwd']) ? $_POST['passwd'] : '';

   if ($pass != $Password) {
      showForm("Wrong password");
      exit();
   }
   else {
     session_start();
     $_SESSION['ppp'] = "hello";
     header('Location: /covid/updatedb.php');
   }
} else {
   showForm();
   exit();
}
?>
