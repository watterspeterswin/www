<?php
$errors = array();

function fieldname_as_text($fn) {
	$fn= str_replace("_"," ",$fn);
	$fn= ucfirst($fn);
	return $fn;
}

// * presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value) {
	return isset($value) && $value !== "";
}

function validate_has_presences($fields_with_presence) {
	global $errors;
	// Expects an assoc. array
	foreach($fields_with_presence as $field ) {
		$value = null;
		if (array_key_exists($field, $_POST)){
			$value= trim($_POST[$field]);
		}
		if (!has_presence($value)) {
			$errors[$field] = fieldname_as_text($field) . " cannot be blank";
		}
	}
}
function validate_password($pswd1,$pswd2) {
	global $errors;
	$password1=$_POST[$pswd1];
	$password2=$_POST[$pswd2];
	if (isset($password1) && isset($password2)) {
		if ($password1 == $password2) {
			return true;
		}
	}
    if (isset($password2)) {
	    $errors[$pswd2] = "Passwords do not match";
	}
	return false;
}

// * string length
// max length
function has_max_length($value, $max) {
	return strlen($value) <= $max;
}

function validate_max_lengths($fields_with_max_lengths) {
	global $errors;
	// Expects an assoc. array
	foreach($fields_with_max_lengths as $field => $max) {
		$value = trim($_POST[$field]);
		if (!has_max_length($value, $max)) {
			$errors[$field] = fieldname_as_text($field) . " is too long";
		}
	}
}
// * inclusion in a set
function has_inclusion_in($value, $set) {
	return in_array($value, $set);
}
?>