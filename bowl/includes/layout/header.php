<?php 
ob_start();
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
<?php 
if (!isset($layout_context)) {
	$layout_context = "public";
}
$TitleName="Widget Corp";
if ($layout_context=="admin") {
	$TitleName.=" Admin";
}
?>
<title><?php echo $TitleName; ?></title>
<link href="stylesheet/public.css" media="all" rel="stylesheet" type="text/css"></link>
</head>
<body>
<div id="header">
	<h1><?php echo $TitleName; ?></?php></h1>
</div>