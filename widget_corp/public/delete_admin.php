<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php
	$current_admin = find_admin_by_id($_GET["admin"]);
	if (!isset($current_admin)) {
		redirect_to("manage_admins.php");
	}
	$id = $current_admin["id"];
	
	$query = "DELETE FROM admins where id={$id} LIMIT 1";
	$result = $dblink->query($query);
	if ($result && $dblink->affected_rows == 1) {
		$_SESSION["message"] = "admin deleted";
		redirect_to("manage_admins.php");
	}
	else {
		$_SESSION["message"] = "Admin delete failed";
		redirect_to("manage_admins.php?admin={$id}");
	}
?>
<?php include("../includes/layout/footer.php"); ?>
