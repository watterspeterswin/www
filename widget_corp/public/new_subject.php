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
		<h2>Create Subject</h2>
        <form action="create_subject.php" method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="" />
			</p>
			<p>Position:
			<select name="position">
			    <?php
				   $subject_count =  get_subject_count() + 1;
				   for ($i=1; $i<=$subject_count; $i++) {
					   echo "<option value=\"{$i}\">{$i}</option>";
				   }
				?>
			</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0">no
				&nbsp;
				<input type="radio" name="visible" value="1">yes
			</p>
			<input type="submit" name="submit" value="Create Subject" />
		</form>
        <br />
        <a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>