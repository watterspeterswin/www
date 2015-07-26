<?php require_once("../includes/functions.php"); ?>
<?php $dblink=GetConnection(); ?>
<?php include("../includes/layout/header.php"); ?>

<div id="main">
	<div id="navigation">
	<?php $subject_set = find_all_subjects(); ?>
	<ul  class="subjects">
	<?php 
		while ($subject=$subject_set->fetch_assoc()) {
	?>
		<li>
		<a href=""><?php echo $subject["menu_name"]; ?></a>
		<?php $page_set = find_pages_for_subject($subject["id"]); ?>
		<ul class="pages">
		<?php 
		while ($pages=$page_set->fetch_assoc()) {
		?>
		<li><a href=""><?php echo $pages["menu_name"]; ?></a></li>
		<?php 
		}
		?>
		<?php $page_set->free_result(); ?>	
		</ul>
	</li>
	<?php
	}
	?>
	</ul>
	
	</div>
	<div id="page">
		<h2>Manage Content</h2>
		<p> Welcome to the Manage Content area.</p>
		<ul>
			<li><a href="manage_content.php">Manage Content</a></li>
			<li><a href="manage_admins.php">Manage Admins</a></li>
			<li><a href="Logout.php">Logout</a></li>
		</ul>
	</div>
</div>
<?php $subject_set->free_result(); ?>
<?php include("../includes/layout/footer.php"); ?>