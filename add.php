<?php
$empid=$_POST['empid'];
$name=$_POST['name'];
$username=$_POST['username'];
$password=$_POST['password'];
$salary=$_POST['salary'];
$deductions=$_POST['deductions'];
$age=$_POST['age'];
$cno=$_POST['cno'];
$designation=$_POST['designation'];
if($empid==""||$name==""||$username==""||$password==""||$salary==""||$deductions==""||$age==""||$cno==""||$designation=="")
{
echo "<h1 align='center'>All fields must be filled</h1>";
return false;
}
$con=mysqli_connect("localhost","root","","sm");
if(!$con){
echo "Not connect successfully";
}
else{
$sql="insert into branch values('$empid','$name','$username','$password','$salary','$deductions','$age','$cno','$designation')";
$result=mysqli_query($con,$sql);
if(!$result){
echo "<p align='center'>Employee not added!</p><br><a align='center' href='add.html'>Go Back</a>";
}
else{
echo "<p align='center'>Employee added!</p><br><p align='center'><a href='add.html'>Go Back</a></p>";
}
}
?>