<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php $layout_context="public"; ?>
<?php include("../includes/layout/header.php"); ?>
<?php find_selected_page(false); ?>

<div id="main">
	<div id="navigation">
	<br />
	<?php echo public_navigation($current_subject, $current_page); ?>
	<br />
	</div>
	<div id="page">
		<ul>
			<?php 
			if ($current_subject) { 
			    $page_set = find_pages_for_subject($current_subject["id"]); 
				$page = $page_set->fetch_assoc();
				echo "<h2>";
				echo htmlentities($page["menu_name"]);
				echo "</h2>";
				echo nl2br(htmlentities($page["content"]));
			}
			elseif ($current_page) {
				if ($current_page["visible"]) {
					echo "<h2>";
					echo htmlentities($current_page["menu_name"]);
					echo "</h2>";
					echo nl2br(htmlentities($current_page["content"]));
				}
			}
			else {
				echo "<p>Welcome</p>";
			}
			?> 
		</ul>
	</div>
</div>

<?php include("../includes/layout/footer.php"); ?>