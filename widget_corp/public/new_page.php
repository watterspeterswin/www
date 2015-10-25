<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_loggedin(); ?>
<?php $layout_context="admin"; ?>
<?php $dblink=GetConnection(); ?>
<?php include("../includes/layout/header.php"); ?>
<?php find_selected_page(); ?>
<?php 
	$current_subject = find_subject_by_id($_GET["subject"]);
	if (!isset($current_subject)) {
		redirect_to("manage_content.php");
	}
	$id = $current_subject["id"];
?>
<div id="main">
	<div id="navigation">
	<?php echo navigation($current_subject, $current_page); ?>
	</div>
	<div id="page">
	<?php echo message(); ?>
	<?php $errors=errors(); ?>
	<?php echo form_errors($errors); ?>
		<h2>Create Page</h2>
        <form action="create_page.php?subject=<?php echo $id ?>" method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="" />
			</p>
			<p>Position:
			<select name="position">
			    <?php
				   $page_count =  get_page_count_for_subject($id) + 1;
				   for ($i=1; $i<=$page_count; $i++) {
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
			<p>Content:<br/>
			<textarea name="content" id="styled" cols="50" rows="5"></textarea>
			</p>
			<input type="hidden" name="subject_id" value="<?php echo $id ?>" />
			<input type="submit" name="submit" value="Create Page" />
		</form>
        <br />
        <a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>