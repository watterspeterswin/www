<div id="footer">Copyright <?php echo date("Y") ?>, Widget Corp</div>
</body>
</html>
<?php
ob_end_flush();

if (isset($dblink)) {
	$dblink->close(); 
}
?>