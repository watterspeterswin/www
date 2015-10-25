<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php
	$current_subject = find_subject_by_id($_GET["subject"],false);
	if (!isset($current_subject)) {
		redirect_to("manage_content.php");
	}
	$id = $current_subject["id"];
	
	$pages_set = find_pages_for_subject($id, false);
	if ($pages_set && $pages_set->num_rows) {
		$_SESSION["message"] = "Subject has pages: cannot delete";
		redirect_to("manage_content.php?subject={$id}");
	}
	
	$query = "DELETE FROM subjects where id={$id} LIMIT 1";
	$result = $dblink->query($query);
	if ($result && $dblink->affected_rows == 1) {
		$_SESSION["message"] = "Subject deleted";
		redirect_to("manage_content.php");
	}
	else {
		$_SESSION["message"] = "Subject delete failed";
		redirect_to("manage_content.php?subject={$id}");
	}
?>
<?php include("../includes/layout/footer.php"); ?>
