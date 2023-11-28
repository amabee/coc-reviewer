<?php 

// // Count All Course
// $selCourse = $conn->query("SELECT COUNT(cou_id) as totCourse FROM course_tbl ")->fetch(PDO::FETCH_ASSOC);


// Count All Sections
 $selSection = $conn->query("SELECT COUNT(section_id) as totSec FROM tbl_section ")->fetch(PDO::FETCH_ASSOC);

// Count All Students
$selStudent = $conn->query("SELECT COUNT(id) AS totStud FROM tbl_students ")->fetch(PDO::FETCH_ASSOC);


 ?>