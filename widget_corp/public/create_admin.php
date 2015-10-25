<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php 
if (isset($_POST["submit"])) {
	
	$username = mysql_prep($_POST["username"]);
	$pswd1 = $_POST["pswd1"];
	$pswd2 = $_POST["pswd2"];
	
	$required_fields =  array("username","pswd1","pswd2");
	validate_has_presences($required_fields);
	$maxsize_fields = array("username" => 20, "pswd1" => 60);
	validate_max_lengths($maxsize_fields);
	
	if (!empty($errors)) {
		$_SESSION["errors"]=$errors;
		redirect_to("new_admin.php");
	}
	$hashed_password = password_encrypt($pswd1);

	$query = "INSERT INTO admins(username,hashed_password) ";
	$query.= "values ('{$username}',md5('{$hashed_password}'))";
	$result = $dblink->query($query);
	if ($result) {
		$_SESSION["message"] = "admin added";
		redirect_to("manage_admins.php");
	}
	else {
		$_SESSION["message"] = "admin add failed";
		redirect_to("new_admin.php");
	}
}
else {
	//This is probably a GET reguest
	redirect_to("new_admin.php");
}

?>

<?php if (isset($dblink)) { $dblink->close();}?>