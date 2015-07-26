<?php require_once("../includes/functions.php"); ?>
<?php
	$dblink=GetConnection();

	$query  = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE visible ";
	$query .= "ORDER BY position";

	$result = $dblink->query($query);
	confirm_query($result);
?>
<?php include("../includes/layout/header.php"); ?>

<div id="main">
	<div id="navigation">
	&nbsp;
	</div>
	<div id="page">
		<h2>Admin Menu</h2>
		<p> Welcome to the admin area.</p>
		<ul>
			<li><a href="manage_content.php">Manage Content</a></li>
			<li><a href="manage_admins.php">Manage Admins</a></li>
			<li><a href="Logout.php">Logout</a></li>
		</ul>
	</div>
</div>
<?php include("../includes/layout/footer.php"); ?>