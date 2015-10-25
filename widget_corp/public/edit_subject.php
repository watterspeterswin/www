<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php find_selected_page(); ?>
<?php
if (!isset($current_subject)) {
	redirect_to("manage_content.php");
}
?>
<?php 
$message=null;
if (isset($_POST["submit"])) {
	
	$required_fields =  array("menu_name","position","visible");
	validate_has_presences($required_fields);
	$maxsize_fields = array("menu_name" => 31);
	validate_max_lengths($maxsize_fields);
	
	if (empty($errors)) {
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		if (isset($_POST["visible"])) {
			$visible = (int) $_POST["visible"];
		}
		
		$query = "update subjects set menu_name='{$menu_name}',position={$position}, visible={$visible} ";
		$query.= "WHERE id={$current_subject["id"]}";
		$result = $dblink->query($query);
		if ($result) {
			$_SESSION["message"] = "Subject updated";
			redirect_to("manage_content.php");
		}
		else {
			$message = "Subject update failed";
		}
	}
}
?>
<?php confirm_loggedin(); ?>
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
		<h2>Edit Subject <?php echo htmlentities($current_subject["menu_name"]);?></h2>
        <form action="edit_subject.php?subject=<?php echo $current_subject["id"];?>" method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="<?php echo $current_subject["menu_name"];?>" />
			</p>
			<p>Position:
			<select name="position">
			    <?php
				   $subject_count = get_subject_count();
				   for ($i=1; $i<=$subject_count; $i++) {
					   echo "<option value=\"{$i}\" ";
					   if ($current_subject["position"]==$i) {
						   echo "selected";
					   }
					   echo ">{$i}</option>";
				   }
				?>
			</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" 
				<?php if ($current_subject["visible"]==0) { echo "checked"; } ?>>no
				&nbsp;
				<input type="radio" name="visible" value="1"
				<?php if ($current_subject["visible"]==1) { echo "checked"; } ?>>yes
			</p>
			<input type="submit" name="submit" value="Save" />
		</form>
        <br />
        <a href="manage_content.php">Cancel</a>
		&nbsp
		&nbsp
		<a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure?')">Delete Subject</a>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>