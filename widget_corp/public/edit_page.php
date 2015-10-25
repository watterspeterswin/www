<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php find_selected_page(); ?>
<?php
if (!isset($current_page)) {
	redirect_to("manage_content.php");
}
?>
<?php 
$message=null;
if (isset($_POST["submit"])) {
	
	$required_fields =  array("menu_name","position","visible","subject_id");
	validate_has_presences($required_fields);
	$maxsize_fields = array("menu_name" => 31);
	validate_max_lengths($maxsize_fields);
	
	if (empty($errors)) {
		$menu_name = mysql_prep($_POST["menu_name"]);
		$content = mysql_prep($_POST["content"]);
		$position = (int) $_POST["position"];
		if (isset($_POST["visible"])) {
			$visible = (int) $_POST["visible"];
		}
		$subject_id = (int) $_POST["subject_id"];
		$query = "update pages set subject_id={$subject_id},content='{$content}',menu_name='{$menu_name}',position={$position}, visible={$visible} ";
		$query.= "WHERE id={$current_page["id"]}";
		$result = $dblink->query($query);
		if ($result) {
			$_SESSION["message"] = "Page updated";
			redirect_to("manage_content.php");
		}
		else {
			$message = "Page update failed";
		}
	}
}
?>
<?php $layout_context="admin"; ?>
<?php include("../includes/layout/header.php"); ?>
<div id="main">
	<div id="navigation">
	<?php echo navigation($current_subject, $current_page); ?>
	</div>
	<div id="page">
	<?php
		if (isset($message)) {
			echo "<div class=\"message\">".htmlentities($message)."</div>";
		}
	?>
	<?php echo message(); ?>
	<?php echo form_errors($errors); ?>
		<h2>Edit Subject <?php echo htmlentities($current_page["menu_name"]);?></h2>
        <form action="edit_page.php?page=<?php echo $current_page["id"];?>" method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="<?php echo $current_page["menu_name"];?>" />
			</p>
			<p>Position:
			<select name="position">
			    <?php
				   $page_count = find_pages_for_subject($current_page["subject_id"]);
				   for ($i=1; $i<=$page_count; $i++) {
					   echo "<option value=\"{$i}\" ";
					   if ($current_page["position"]==$i) {
						   echo "selected";
					   }
					   echo ">{$i}</option>";
				   }
				?>
			</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" 
				<?php if ($current_page["visible"]==0) { echo "checked"; } ?>>no
				&nbsp;
				<input type="radio" name="visible" value="1"
				<?php if ($current_page["visible"]==1) { echo "checked"; } ?>>yes
			</p>
			<p>Content:<br/>
				<textarea name="content" id="styled" cols="50" rows="5"><?php echo htmlentities($current_page["content"]);?></textarea>
			</p>

			<input type="hidden" name="subject_id" value="<?php echo $current_page["subject_id"] ?>" />

			<input type="submit" name="submit" value="Save" />
		</form>
        <br />
        <a href="manage_content.php">Cancel</a>
		&nbsp
		&nbsp
		<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure?')">Delete Page</a>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>