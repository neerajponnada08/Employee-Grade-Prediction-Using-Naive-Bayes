<?php
$username = $_POST['username'];
$password = $_POST['password'];
if($username==""||$password=="")
{
echo "<h1 align='center'>All fields must be filled</h1>";
return false;
}
$con=mysqli_connect("localhost","root","","sm");
if(!$con){
echo "Not connect successfully";
}
else{
$sql="select username from branch where username='$username' and password='$password';";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_row($result);
if($row[0]==""){
echo "User not found";
}
else{
echo "<script>window.location.href = 'homepage.html'</script>";
}
}
?>