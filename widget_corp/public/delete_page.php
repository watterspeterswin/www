<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php
	$current_page = find_page_by_id($_GET["page"]);
	if (!isset($current_page)) {
		redirect_to("manage_content.php");
	}
	$id = $current_page["id"];
	
	$query = "DELETE FROM pages where id={$id} LIMIT 1";
	$result = $dblink->query($query);
	if ($result && $dblink->affected_rows == 1) {
		$_SESSION["message"] = "Page deleted";
		redirect_to("manage_content.php");
	}
	else {
		$_SESSION["message"] = "Page delete failed";
		redirect_to("manage_content.php?page={$id}");
	}
?>
<?php include("../includes/layout/footer.php"); ?>
