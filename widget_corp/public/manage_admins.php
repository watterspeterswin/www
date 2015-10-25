<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_loggedin(); ?>
<?php $layout_context="admin"; ?>
<?php $dblink=GetConnection(); ?>
<?php require_once("../includes/layout/header.php"); ?>
<?php find_selected_page(); ?>

<div id="main">
	<div id="navigation">
	<br />
	<a href="admin.php">&laquo; Main menu</a>
	<?php echo admin_navigation($current_admin); ?>
	<br />
	<a href="new_admin.php">+ Add admin</a>

	</div>
	<div id="page">
	    <?php echo message(); ?>
		<ul>
			<?php 
			if ($current_admin) { 
			    echo "<h2>Manage admin</h2>";
				echo "User Name: ";
				echo htmlentities($current_admin["username"]);
				echo "<br/><br/><a href=\"edit_admin.php?admin={$current_admin["id"]}\">Change Password</a>";
				echo "<br/><br/><a href=\"delete_admin.php?admin={$current_admin["id"]}\" onclick=\"return confirm('Are you sure?')\">Delete</a>";
			}
			?> 
			<hr/>
			<?php
			    $password="secret";
				echo "<br />";
				$hash= password_encrypt($password);
				echo $hash;
			?>
		</ul>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>