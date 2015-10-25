<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $layout_context="admin"; ?>
<?php $dblink=GetConnection(); ?>
<?php require_once("../includes/layout/header.php"); ?>
<?php find_selected_page(); ?>
<?php 
$username = "";
if (isset($_POST["submit"])) {
	
	$username = mysql_prep($_POST["username"]);
	$pswd1 = $_POST["pswd1"];
	
	$required_fields =  array("username","pswd1");
	validate_has_presences($required_fields);

	if (!empty($errors)) {
		$_SESSION["errors"]=$errors;
		redirect_to("login.php");
	}
	$hashed_password = password_encrypt($pswd1);
    $found_admin = attempt_login($username, $pswd1);
	if ($found_admin) {
		$_SESSION["username"] = $found_admin["username"];
		$_SESSION["admin_id"] = $found_admin["id"];
		redirect_to("admin.php");
	}
	else {
		$_SESSION["message"] = "Username/Password not found.";
		redirect_to("login.php");
	}
}

?>
<div id="main">
	<div id="navigation">
<br />
	</div>
	<div id="page">
	<?php echo message(); ?>
	<?php $errors=errors(); ?>
	<?php echo form_errors($errors); ?>
		<h2>Login</h2>
        <form action="login.php" method="post">
			<p>User Name:
				<input type="text" name="username" value="<?php echo $username; ?>" />
			</p>
			<p>Password:
				<input type="password" name="pswd1" value="" />
			</p>
			<input type="submit" name="submit" value="Submit" />
		</form>
        <br />
	</div>
</div>
<?php include("../includes/layout/footer.php"); ?>