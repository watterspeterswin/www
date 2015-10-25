<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php find_selected_page(); ?>
<?php
if (!isset($current_admin)) {
	redirect_to("manage_admins.php");
}
?>
<?php 
$message=null;
if (isset($_POST["submit"])) {
	
	$required_fields =  array("pswd1","pswd2");
	validate_has_presences($required_fields);
	$maxsize_fields = array("pswd1" => 60);
	validate_max_lengths($maxsize_fields);
	validate_password("pswd1","pswd2");
	
	if (empty($errors)) {
		$username = mysql_prep($_POST["username"]);
		$pswd1 = $_POST["pswd1"];
		$pswd2 = $_POST["pswd2"];		
		$hashed_password = password_encrypt($pswd1);
		$query = "update admins set hashed_password='{$hashed_password}'";
		$query.= "WHERE id={$current_admin["id"]}";
		$result = $dblink->query($query);
		if ($result) {
			$_SESSION["message"] = "Password updated";
			redirect_to("manage_admins.php");
		}
		else {
			$message = "Admin update failed";
		}
	}
}
?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layout/header.php"); ?>
<div id="main">
	<div id="navigation">
	<?php echo admin_navigation($current_admin); ?>
	</div>
	<div id="page">
	<?php
		if (isset($message)) {
			echo "<div class=\"message\">".htmlentities($message)."</div>";
		}
	?>
	<?php echo message(); ?>
	<?php echo form_errors($errors); ?>
		<h2>Change Password for <?php echo htmlentities($current_admin["username"]);?></h2>
        <form action="edit_admin.php?admin=<?php echo $current_admin["id"];?>" method="post">
			<p>Password:
				<input type="password" name="pswd1" value="" />
			</p>
			<p>Confirm Password:
				<input type="password" name="pswd2" value="" />
			</p>
			<input type="hidden" name="username" value="<?php echo $current_page["username"] ?>" />
			<input type="submit" name="submit" value="Save" />
		</form>
        <br />
        <a href="manage_admins.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>