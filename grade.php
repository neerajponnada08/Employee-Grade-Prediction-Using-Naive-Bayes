<?php
$empid=$_POST['empid'];

/*checking whether employee is pre4sent or not*/
if($empid=="")
{
echo "<h1 align='center'>Emp id must be filled</h1>";
return false;
}

/*Opening connection*/
$con=mysqli_connect("localhost","root","","sm");

/*Checking Connection*/
if(!$con){
echo "Not connect successfully";
echo "<p align='center'><a href='grade.html' > Go Back </a></p><br><br>;";

}

/*If connection is successful*/
else{
/*Naive Bayes Classification Starts Here*/
$exp=$_POST['exp'];
$acc=$_POST['acc'];
$prjtyp=$_POST['prjtyp'];

/*Checking whether already a row combination is present or not*/
$sql1="select gradevalue from grade where empid='$empid' and experience='$exp' and accuracy='$acc' and partprojecttype='$prjtyp';";
$result1=mysqli_query($con,$sql1);
if($result1){
  $check_num_rows=mysqli_num_rows($result1);
  if($check_num_rows!=0){
    $row1=mysqli_fetch_row($result1);
    echo "<br/><br/><br/><h3 align='center'>Employee Grade is Already available in the Database with Grade '$row1[0]'</h3>";
    echo "<p align='center'><a href='grade.html' > Go Back </a></p><br><br>;";

    return false;
  }




else{

  /*Cheking already an employee with other combination is present or not*/
  $sql2="select empid from grade where empid='$empid';";
  $result2=mysqli_query($con,$sql2);
  if($result2){
    $check_num_rows1=mysqli_num_rows($result2);
    if($check_num_rows1!=0){
      echo "<br/><br/><br/><br/><h3 align='center'>Grade Can be Calculated for a new Employee Only</h3>";
      echo "<p align='center'><a href='grade.html' > Go Back </a></p><br><br>;";
      return false;
    }

    /*if the combination is new, applying Naive Bayes Classifier*/
  else{

    //echo "Applying Naive Bayes!!";

    /*Calculating total no of rows*/
    $totrowsql="select* from grade;";
    $totrowresult=mysqli_query($con,$totrowsql);
    $totrows=mysqli_num_rows($totrowresult);
    //echo "$totrows<br/><br/>";

    /*calculating probability of grade=good*/
    $sql3="select* from grade where gradevalue='good';";
    $result3=mysqli_query($con,$sql3);
    $good=mysqli_num_rows($result3);
    $probofgood=$good/$totrows;
    //echo "$probofgood<br/><br/>";

    /*calculating probability of grade=average*/
    $sql4="select* from grade where gradevalue='average';";
    $result4=mysqli_query($con,$sql4);
    $average=mysqli_num_rows($result4);
    $probofaverage=$average/$totrows;
    //echo "$probofaverage<br/><br/><br/>";

    /*calculating probability of 1st attribute with good*/
    $sql5="select* from grade where gradevalue='good' and experience='$exp';";
    $result5=mysqli_query($con,$sql5);
    $countexpgood=mysqli_num_rows($result5);
    $probexpwithgood=$countexpgood/$good;
    //echo "$countexpgood<br/><br/>";
    //echo "$probexpwithgood<br/><br/>";

    /*calculating probability of 1st attribute with average*/
    $sql6="select* from grade where gradevalue='average' and experience='$exp';";
    $result6=mysqli_query($con,$sql6);
    $countexpaverage=mysqli_num_rows($result6);
    $probexpwithaverage=$countexpaverage/$average;
    //echo "$countexpaverage<br/><br/>";
    //echo "$probexpwithaverage<br/><br/>";

    /*calculating probability of 2nd attribute with good*/
    $sql7="select* from grade where gradevalue='good' and accuracy='$acc';";
    $result7=mysqli_query($con,$sql7);
    $countaccgood=mysqli_num_rows($result7);
    $probaccwithgood=$countaccgood/$good;
    //echo "$countaccgood<br/><br/>";
    //echo "$probaccwithgood<br/><br/>";

    /*calculating probability of 2nd attribute with average*/
    $sql8="select* from grade where gradevalue='average' and accuracy='$acc';";
    $result8=mysqli_query($con,$sql8);
    $countaccaverage=mysqli_num_rows($result8);
    $probaccwithaverage=$countaccaverage/$average;
    //echo "$countaccaverage<br/><br/>";
    //echo "$probaccwithaverage<br/><br/>";

    /*calculating probability of 3rd attribute with good*/
    $sql9="select* from grade where gradevalue='good' and partprojecttype='$prjtyp';";
    $result9=mysqli_query($con,$sql9);
    $countprjtypgood=mysqli_num_rows($result9);
    $probprjtypwithgood=$countprjtypgood/$good;
    //echo "$countprjtypgood<br/><br/>";
    //echo "$probprjtypwithgood<br/><br/>";

    /*calculating probability of 3rd attribute with average*/
    $sql10="select* from grade where gradevalue='average' and partprojecttype='$prjtyp';";
    $result10=mysqli_query($con,$sql10);
    $countprjtypaverage=mysqli_num_rows($result10);
    $probprjtypwithaverage=$countprjtypaverage/$average;
    //echo "$countprjtypaverage<br/><br/>";
    //echo "$probprjtypwithaverage<br/><br/>";

    /*calculating probability of old data with grade=good*/
    $probofoldwithgood= $probexpwithgood * $probaccwithgood * $probprjtypwithgood;

    /*calculating probability of old data with grade=average*/
    $probofoldwithaverage = $probexpwithaverage * $probaccwithaverage * $probprjtypwithaverage;

    /*calculating probability of good for new data*/
    $probofgoodfornewdata = $probofoldwithgood * $probofgood;

    /*calculating probability of average for new data*/
    $probofaveragefornewdata = $probofoldwithaverage * $probofaverage;

    /*Calculating the resultant grade of the Emplopyee*/
    if($probofgoodfornewdata>$probofaveragefornewdata){
      $resultantgrade = "good";
    }
    else{
      $resultantgrade = "average";
    }

    //echo "$resultantgrade<br><br><br><br>";

    /*Inserting emp grade as a new row ihn the database*/
    $updatesql="insert into grade values('$empid','$exp','$acc','$prjtyp','$resultantgrade');";
    $updateresult = mysqli_query($con,$updatesql);
    if(!$updatesql){
      echo "<br><br><h3> New Employee Details are not updated in the Database!! </h3><br><br>";
      echo "<p align='center'><a href='grade.html' > Go Back </a></p><br><br>;";
    }
    else{
       echo "<br><p align='center'>New Employee Grade is Calculated Using Naive Bayes Algorithm</p><br><br>";
       echo "<h3 align='center'>Grade of the New Employee with Employee id '$empid' is '$resultantgrade'</h3>";
      echo "<p align='center'><a href='grade.html' > Go Back </a></p><br><br>;";
    }


  }
}
}

}

}
