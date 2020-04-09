<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password,"covid");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_POST['sub'])) {

  $sql = "SELECT Last_Updated_Time FROM covid where id = 1" ;

  $result = mysqli_query($conn, $sql);

  $row = mysqli_fetch_array($result);
  if($row)
  {

  $lut  =$row["Last_Updated_Time"];
  $c = $_POST["Confirmed"];
  $r =$_POST["Recovered"];
  $d =  $_POST["Death"];
  $sql = "INSERT INTO timeseries (Date,Confirmed,Recovered,Death) VALUES('$lut',' $c', '$r', '$d') ";
  $retval =mysqli_query($conn,$sql);
  if(! $retval ) {
               echo "<script>alert('Not updated timeseries')</script>";
            }
}
}
if (isset($_SESSION['ppp']) ||!empty($_POST['Confirmed'])){
// if(!empty($_POST['Confirmed'])){


if(count($_POST)>0) {


  if(isset($_POST['Confirmed'])) {

    $c = (int)$_POST["Confirmed"];
    $r =(int)$_POST["Recovered"];
    $d =  (int)$_POST["Death"];
    $f = $c -$r;
    $f = $f - $d;

    // echo "<script>alert('".$f."')</script>";
mysqli_query($conn,"UPDATE covid set Confirmed='" . $_POST['Confirmed'] . "', Recovered='" . $_POST['Recovered'] . "', Death='" . $_POST['Death'] . "', Active='" . $f  . "' WHERE State='" . $_POST['State'] . "'");
$message = "Record Modified Successfully";

$sql = "SELECT sum(Confirmed) as c,sum(Recovered) as r ,sum(Death) as d ,sum(Active) as a FROM covid where id > 1" ;
if($result = mysqli_query($conn, $sql)){
if(mysqli_num_rows($result) > 0){
while($row = mysqli_fetch_array($result)){
  mysqli_query($conn,"UPDATE covid set Confirmed='" . $row['c'] . "', Recovered='" . $row['r'] . "', Death='" . $row['d'] . "', Active='" . $row['a']  . "' WHERE id = 1");
}
echo "</tbody></table></form>";
// Free result set
mysqli_free_result($result);
} else{
echo "No records matching your query were found.";
}
} else{
echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
$d = date("Y-m-d h:i:sa");
mysqli_query($conn,"UPDATE covid set Last_Updated_Time='" . $d . "' WHERE State='" . $_POST['State'] . "' or id = 1");

}}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid-19 Tracker</title>
    <link rel="stylesheet" href="style.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">


      <link rel="stylesheet" href=
  "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
      <script src=
  "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
      </script>

      <script src=
  "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
      </script>

      <script src=
  "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
      </script>


  <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
  </head>
  <body>



    <?php
    $sql = "SELECT * FROM covid order by Confirmed Desc";
    if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){
    echo "<form action='updatedb.php' method='post'> <table class='table table-striped table-dark table-hover table-bordered '><thead>";
    echo "<tr>";
    echo "<th>State</th>";
    echo "<th>Confirmed</th>";
    echo "<th>Recovered</th>";
    echo "<th>Deaths</th>";
    echo "<th>Active</th>";
    echo "</tr></thead><tbody>";
    while($row = mysqli_fetch_array($result)){
    echo "<form action='updatedb.php' method='post'>
          <tr>";
    echo "<td> <input type='text' name='State' value = '" . $row['State'] . "'readonly > </td>";
    echo "<td> <input type='text' name='Confirmed' value = '" . $row['Confirmed'] . "' > </td>";
    echo "<td> <input type='text' name='Recovered' value = '" . $row['Recovered'] . "' > </td>";
    echo "<td> <input type='text' name='Death' value = '" . $row['Death'] . "' > </td>";
    echo "<td> <input type='text' name='Active' value = '" . $row['Active'] . "' > </td>";


    if($row['State'] == "Total")
    {
      echo "<td> <input type='submit' name='sub' value='Updatet'> </td>";
    }
    else {
      echo "<td> <input type='submit' name='submit' value='Update'> </td>";
    }
    echo "</tr></form>";
    }
    echo "</tbody></table>";
    // Free result set
    mysqli_free_result($result);
    } else{
    echo "No records matching your query were found.";
    }
    } else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }?>







  </body>
</html>
<?php
}
session_destroy(); ?>
