<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");

    $institute_id = $_SESSION["institute_id"];

	$program_id = mysql_real_escape_string($_POST["prog_id"]);
	# for department details
	$sql = "SELECT t1.department_id,t1.department_code FROM department_m_details t1 INNER JOIN program_department t2 
			ON (t1.department_id=t2.department_id AND t2.program_id='$program_id')";
	if ($program_id=="all") {
		$sql = "SELECT department_id,department_code FROM department_m_details WHERE institute_id='$institute_id'";
	}
	$result = mysql_query($sql);
	//echo $sql;
	if ($result) {
		$str = "<option value='all'>All</option>";
		while ($row=mysql_fetch_array($result)) {
			$str.="<option value='".$row["department_id"]."'>".$row["department_code"]."</option>";
		}
		echo $str;
	}else{
		echo "string";
	}
?>