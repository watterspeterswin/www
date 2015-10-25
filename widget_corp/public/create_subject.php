<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php 
if (isset($_POST["submit"])) {
	
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int) $_POST["position"];
	if (isset($_POST["visible"])) {
		$visible = (int) $_POST["visible"];
	}
		
	$required_fields =  array("menu_name","position","visible");
	validate_has_presences($required_fields);
	$maxsize_fields = array("menu_name" => 31);
	validate_max_lengths($maxsize_fields);
	
	if (!empty($errors)) {
		$_SESSION["errors"]=$errors;
		redirect_to("new_subject.php");
	}
	$query = "INSERT INTO subjects(menu_name,position,visible) ";
	$query.= "values ('{$menu_name}',{$position},{$visible})";
	$result = $dblink->query($query);
	if ($result) {
		$_SESSION["message"] = "Subject added";
		redirect_to("manage_content.php");
	}
	else {
		$_SESSION["message"] = "Subject add failed";
		redirect_to("new_subject.php");
	}
}
else {
	//This is probably a GET reguest
	redirect_to("new_subject.php");
}

?>

<?php if (isset($dblink)) { $dblink->close();}?>