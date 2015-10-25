<?php
function redirect_to($new_location) {
	header("Location: ". $new_location);
	exit;
}
function password_encrypt($password) {
	
	$format="$2y$10$";
	$salt = "Salt22CharactersOrMore";
	$format_and_salt = $format . $salt;
	$hash= crypt($password, $format_and_salt);
	return $hash;
}

function password_check($password, $hashed_password) {
	$hash = password_encrypt($password);
	if ($hash == $hashed_password) {
		return true;
	}
	else {
		return false;
	}
}

function attempt_login($username, $password) {
	
	$admin = find_admin_by_username($username);
	if ($admin) {
		if (password_check($password,$admin["hashed_password"])) {
			return $admin;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
}

function GetConnection() 
{
	define("DB_USER", "root");
	define("DB_HOST","localhost");
	define("DB_PASSWORD","root");
	define("DB_DBNAME","widgets");
	$dblink=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DBNAME);
	if (mysqli_connect_errno()) {
		die("Database connection failed: ". 
		     mysqli_connect_error() .
			 " (" . mysqli_connect_errno() . ")"
		);
	}
	return $dblink;
}


function mysql_prep($instring) {
	
	global $dblink;
	
	$instring = $dblink->real_escape_string($instring);
	
	return $instring;
}

function confirm_query($result) {
	if (!$result) {
		die("database query failed");
	}
}

function get_subject_count() {
	
    global $dblink;
	
	$query  = "SELECT count(*) as subject_count ";
	$query .= "FROM subjects ";

	$subject_set = $dblink->query($query);
	confirm_query($subject_set);
    $subject_count = $subject_set->fetch_assoc();
	
	return $subject_count["subject_count"];
}

function find_all_subjects($public=true) {
	
    global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM subjects ";
	if ($public) {
		$query .= "WHERE visible ";
	}
	$query .= "ORDER BY position";

	$subject_set = $dblink->query($query);
	confirm_query($subject_set);
		
	return $subject_set;
}

function find_all_admins() {
	
    global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM admins ";
	$query .= "ORDER BY username";

	$admins_set = $dblink->query($query);
	confirm_query($admins_set);
		
	return $admins_set;
}

function find_pages_for_subject($subject_id, $public=true, $default=false) {	
	global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE subject_id = {$subject_id} ";

	if ($public) {
		$query .="AND visible ";
	}
	$query .= "ORDER BY position ";
	if ($default) {
		$query .= "Limit 1";
	}

	$page_result = $dblink->query($query);
	confirm_query($page_result);
	
	return $page_result;
}

function get_page_count_for_subject($subject_id)  {
	
    global $dblink;
	
	$query  = "SELECT count(*) as page_count ";
	$query .= "FROM pages ";
	$query .= "WHERE subject_id = {$subject_id} ";

	$page_set = $dblink->query($query);
	confirm_query($page_set);
    $page_count = $page_set->fetch_assoc();
	
	return $page_count["page_count"];
}

function find_page_by_id($page_id,$public=false) {	
	global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM pages ";
	$query .= "WHERE id = {$page_id} ";
	if ($public) {
		$query .= "AND visible ";		
	}
	$query .= "ORDER BY position";

	$page_result = $dblink->query($query);
	confirm_query($page_result);
	
	if ($page = $page_result->fetch_assoc()) {
		return $page;
	}
	else {
		return null;
	}
}

function find_subject_by_id($subject_id) {	
	global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE id = {$subject_id} ";
	$query .= "ORDER BY position";

	$subject_result = $dblink->query($query);
	confirm_query($subject_result);
	
	if ($subject = $subject_result->fetch_assoc()) {
		return $subject;
	}
	else {
		return null;
	}
}

function find_admin_by_id($admin_id) {	
	global $dblink;
	
	$query  = "SELECT * ";
	$query .= "FROM admins ";
	$query .= "WHERE id = {$admin_id} ";

	$admin_result = $dblink->query($query);
	confirm_query($admin_result);
	
	if ($admin = $admin_result->fetch_assoc()) {
		return $admin;
	}
	else {
		return null;
	}
}

function find_admin_by_username($username) {	
	global $dblink;
	$safe_username=mysql_prep($username);
	$query  = "SELECT * ";
	$query .= "FROM admins ";
	$query .= "WHERE username = '{$safe_username}' LIMIT 1 ";

	$admin_result = $dblink->query($query);
	confirm_query($admin_result);
	
	if ($admin = $admin_result->fetch_assoc()) {
		return $admin;
	}
	else {
		return null;
	}
}


function find_selected_page($public=false) {
	
	global $current_subject;
	global $current_page;
	global $current_admin;
	$current_subject = null;
	$current_page = null;
	$current_admin = null;
	
	if (isset($_GET["subject"])) {
		$current_subject =  find_subject_by_id($_GET["subject"]);
	} elseif (isset($_GET["page"])) {
		$current_page =  find_page_by_id($_GET["page"],$public);
	} elseif (isset($_GET["admin"])) {
		$current_admin =  find_admin_by_id($_GET["admin"]);
	} 	
}

function navigation($p_subject, $p_page) {

	$subject_set = find_all_subjects(false); 
	$output ="<ul  class=\"subjects\">";
	while ($subject=$subject_set->fetch_assoc()) {
	    $output.="<li";
	    if ($subject["id"]==$p_subject["id"]) {
		    $output.= " class=\"selected\"" ;
	    }
		$output.=">";
		$output.="<a href=\"manage_content.php?subject=";
		$output.=urlencode($subject["id"])."\">";
		$output.=htmlentities($subject["menu_name"]);
		$output.="</a><ul class=\"pages\">";
		$page_set = find_pages_for_subject($subject["id"],false); 
		while ($pages=$page_set->fetch_assoc()) {
			$output.="<li"; 
			if ($pages["id"]==$p_page["id"]) {
			   $output.=" class=\"selected\"";
			}
			$output.=">"; 
			$output.="<a href=\"manage_content.php?page=";
			$output.=urlencode($pages["id"]);
			$output.="\">";
			$output.=htmlentities($pages["menu_name"]);
			$output.="</a></li>";
		}
        $page_set->free_result();
		$output.="</ul></li>";
	}
	$output.="</ul>";
	$subject_set->free_result();
	
	return $output;
}

function public_navigation($p_subject, $p_page) {

	$subject_set = find_all_subjects(); 
	$output ="<ul  class=\"subjects\">";
	while ($subject=$subject_set->fetch_assoc()) {
	    $output.="<li";
	    if ($subject["id"]==$p_subject["id"]) {
		    $output.= " class=\"selected\"" ;
	    }
		$output.=">";
		$output.="<a href=\"index.php?subject=";
		$output.=urlencode($subject["id"])."\">";
		$output.=htmlentities($subject["menu_name"]);
		$output.="</a>";
		if ($subject["id"]==$p_subject["id"]
		  ||$subject["id"]==$p_page["subject_id"]) {
			$output.="<ul class=\"pages\">";
			$page_set = find_pages_for_subject($subject["id"]); 
			while ($pages=$page_set->fetch_assoc()) {
				$output.="<li"; 
				if ($pages["id"]==$p_page["id"]) {
				   $output.=" class=\"selected\"";
				}
				$output.=">"; 
				$output.="<a href=\"index.php?page=";
				$output.=urlencode($pages["id"]);
				$output.="\">";
				$output.=htmlentities($pages["menu_name"]);
				$output.="</a></li>";
			}
			$page_set->free_result();
			$output.="</ul>";
		}
		$output.="</li>";
	}
	$output.="</ul>";
	$subject_set->free_result();
	
	return $output;
}

function admin_navigation($p_admin) {

	$admin_set = find_all_admins(false); 
	$output ="<ul  class=\"admins\">";
	while ($admin=$admin_set->fetch_assoc()) {
	    $output.="<li";
	    if ($admin["id"]==$p_admin["id"]) {
		    $output.= " class=\"selected\"" ;
	    }
		$output.=">";
		$output.="<a href=\"manage_admins.php?admin=";
		$output.=urlencode($admin["id"])."\">";
		$output.=htmlentities($admin["username"]);
		$output.="</a>";
		$output.="</li>";
	}
	$output.="</ul>";
	$admin_set->free_result();
	
	return $output;
}


function form_errors($errors=array()) {
	$output = "";
	if (!empty($errors)) {
	  $output .= "<div class=\"error\">";
	  $output .= "Please fix the following errors:";
	  $output .= "<ul>";
	  foreach ($errors as $key => $error) {
	    $output .= "<li>";
		$output .= htmlentities($error);
		$output .= "</li>";
	  }
	  $output .= "</ul>";
	  $output .= "</div>";
	}
	return $output;
}

function confirm_loggedin(){
	if (!isset($_SESSION["admin_id"])) {
		redirect_to("login.php");
	}
}
?>