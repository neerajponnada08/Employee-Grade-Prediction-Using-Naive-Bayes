<?php
$username = $_POST['username'];
$password = $_POST['password'];
session_start(); // starts PHP session!
$_SESSION['user'] = $username;
if($username==""||$password=="")
{
echo "<script language='javascript'>alert('All Fields must be filled');
window.location.href='main.html';
</script>";
return false;
}
$con=mysqli_connect("localhost","root","","sm");
if(!$con){
echo "Not connect successfully";
}
else{
$sql="select username,password from branch where username ='$username'; ";
$result=mysqli_query($con,$sql);
$row=mysqli_fetch_row($result);
if($row[0]==""){
echo "<script language='javascript'>alert('User is not registered');
window.location.href='adminlogin1.html';
</script>";
}
else{
  if($row[1]==$password)
  {
echo "<script>window.location.href = 'homepage.html'</script>";
  }
  else{
echo "<script language='javascript'>alert('Password is incorrect');
window.location.href='adminlogin1.html';
</script>";
  }
  }


}

?>
