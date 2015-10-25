<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_loggedin(); ?>
<?php $layout_context="admin"; ?>
<?php $dblink=GetConnection(); ?>
<?php include("../includes/layout/header.php"); ?>
<?php find_selected_page(); ?>

<div id="main">
	<div id="navigation">
	<br />
	<a href="admin.php">&laquo; Main menu</a>
	<?php echo navigation($current_subject, $current_page); ?>
	<br />
	<a href="new_subject.php">+ Add subject</a><br/>

	</div>
	<div id="page">
	    <?php echo message(); ?>
		<ul>
			<?php 
			if ($current_subject) { 
			    echo "<h2>Manage Subject</h2>";
				echo "Menu Name: ";
				echo htmlentities($current_subject["menu_name"]);
				echo "<br/>  Position: {$current_subject["position"]}";
				echo "<br/>   Visible: ";
				echo $current_subject["visible"]==0 ? "no" : "yes";
				echo "<br/><br/><a href=\"edit_subject.php?subject={$current_subject["id"]}\">Edit Subject</a>";
				echo "<br/><br/><a href=\"new_page.php?subject={$current_subject["id"]}\">Add Page</a>";
			}
			elseif ($current_page) {
				echo "<h2>Manage Page</h2>";
				echo "Menu Name: ";
				echo htmlentities($current_page["menu_name"]);
				echo "<br/>  Position: {$current_page["position"]}";
				echo "<br/>   Visible: ";
				echo $current_page["visible"]==0 ? "no" : "yes";
				echo "<br/>   Content: ";
				echo "<div class=\"view-content\">";
				echo htmlentities($current_page["content"]);
				echo "</div>";
				
				echo "<br/><br/><a href=\"new_page.php?subject={$current_page["subject_id"]}\">Add Page</a>";
				echo "<br/><br/><a href=\"edit_page.php?page={$current_page["id"]}\">Edit Page</a>";
				echo "<br/><br/><a href=\"delete_page.php?page={$current_page["id"]}\">Delete Page</a>";

			}
			else {
				echo "Please select a subject or page";
			}
			?> 
		</ul>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>