
<?php

require_once('protector.php');
function showForm($error="LOGIN"){
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php echo $error; ?>
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="pwd">
   Password:
    <table>
      <tr>
        <td><input name="passwd" type="password"/></td>
      </tr>
      <tr>
        <td align="center"><br/>
         <input type="submit" name="submit_pwd" value="Login"/>
        </td>
      </tr>
    </table>
  </form>
  </body>
</html>
<?php
}

?>
