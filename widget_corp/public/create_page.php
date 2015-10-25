<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php 
if (isset($_POST["submit"])) {
	$current_subject = find_subject_by_id($_POST["subject_id"]);
	if (!isset($current_subject)) {
		redirect_to("manage_content.php");
	}
	$subject_id = $current_subject["id"];
	
	$menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int) $_POST["position"];
	if (isset($_POST["visible"])) {
		$visible = (int) $_POST["visible"];
	}
	$content = mysql_prep($_POST["content"]);	
	$required_fields =  array("menu_name","position","visible","subject_id");
	validate_has_presences($required_fields);
	$maxsize_fields = array("menu_name" => 31);
	validate_max_lengths($maxsize_fields);
	
	if (!empty($errors)) {
		$_SESSION["errors"]=$errors;
		redirect_to("new_page.php?subject={$subject_id}");
	}
	$query = "INSERT INTO pages(subject_id,menu_name,position,visible,content) ";
	$query.= "values ({$subject_id},'{$menu_name}',{$position},{$visible},'{$content}')";
	$result = $dblink->query($query);
	if ($result) {
		$_SESSION["message"] = "page added";
		redirect_to("manage_content.php");
	}
	else {
		$_SESSION["message"] = "page add failed";
		redirect_to("manage_content.php?subject={$subject_id}");
	}
}
else {
	//This is probably a GET reguest
	redirect_to("manage_content.php");
}

?>

<?php if (isset($dblink)) { $dblink->close();}?>