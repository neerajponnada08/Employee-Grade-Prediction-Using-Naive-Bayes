<?php
$empid=$_POST['empid'];
if($empid=="")
{
echo "<h1 align='center'>Field must be filled</h1>";
return false;
}
$con=mysqli_connect("localhost","root","","sm");
if(!$con){
echo "Not connect successfully";
}
else{
$sql="select empid from branch where empid='$empid'";
$result=mysqli_query($con,$sql);
if(!$result){
echo "Employee Not Found";
}
else{
$sql1="delete from branch where empid='$empid'";
$result1=mysqli_query($con,$sql1);
if(!$result1){
echo "<p align='center'>Employee not Deleted!</p><br><a align='center' href='delete.html'>Go Back</a>";
}
else{
echo "<p align='center'>Employee Deleted!</p><br><a align='center' href='delete.html'>Go Back</a>";	
}
}
}
?>