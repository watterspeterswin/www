<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_loggedin(); ?>
<?php $layout_context="admin"; ?>
<?php $dblink=GetConnection(); ?>
<?php include("../includes/layout/header.php"); ?>
<?php find_selected_page(); ?>

<div id="main">
	<div id="navigation">
	<?php echo navigation($current_subject, $current_page); ?>
	</div>
	<div id="page">
	<?php echo message(); ?>
	<?php $errors=errors(); ?>
	<?php echo form_errors($errors); ?>
		<h2>Create admin</h2>
        <form action="create_admin.php" method="post">
			<p>User Name:
				<input type="text" name="username" value="" />
			</p>
			<p>Password:
				<input type="password" name="pswd1" value="" />
			</p>
			<p>Confirm Password:
				<input type="password" name="pswd2" value="" />
			</p>
			<input type="submit" name="submit" value="Create Admin" />
		</form>
        <br />
        <a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>