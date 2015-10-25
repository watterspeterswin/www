<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_loggedin(); ?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layout/header.php"); ?>
<div id="main">
	<div id="navigation">
	&nbsp;
	</div>
	<div id="page">
		<h2>Admin Menu</h2>
		<p> Welcome to the admin area, <?php echo htmlentities($_SESSION["username"]); ?></p>
		<ul>
			<li><a href="manage_content.php">Manage Content</a></li>
			<li><a href="manage_admins.php">Manage Admins</a></li>
			<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>
</div>
<?php include("../includes/layout/footer.php"); ?>