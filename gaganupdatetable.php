<?php$sql = "SELECT * FROM covid";
if($result = mysqli_query($conn, $sql)){
if(mysqli_num_rows($result) > 0){
echo "<table>";
echo "<tr>";
echo "<th>State</th>";
echo "<th>Confirmed</th>";
echo "<th>Recovered</th>";
echo "<th>Deaths</th>";
echo "<th>Active</th>";
echo "</tr>";
while($row = mysqli_fetch_array($result)){
echo "<tr>";
echo "<td>" . $row['State'] . "</td>";
echo "<td>" . $row['Confirmed'] . "</td>";
echo "<td>" . $row['Recovered'] . "</td>";
echo "<td>" . $row['Death'] . "</td>";
echo "<td>" . $row['Active'] . "</td>";
echo "</tr>";
}
echo "</table>";
// Free result set
mysqli_free_result($result);
} else{
echo "No records matching your query were found.";
}
} else{
echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}?>
