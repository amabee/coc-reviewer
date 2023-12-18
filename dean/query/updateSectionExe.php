<?php
 include("../../../conn.php");
 extract($_POST);


$newCourseName = strtoupper($newCourseName);
$updCourse = $conn->query("UPDATE tbl_section SET section_id='$newCourseName' WHERE section_id='$course_id' ");
if($updCourse)
{
	   $res = array("res" => "success", "newCourseName" => $newCourseName);
}
else
{
	   $res = array("res" => "failed");
}



 echo json_encode($res);	
?>