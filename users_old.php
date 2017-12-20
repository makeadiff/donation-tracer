<?php
require('common.php');
 
$crud = new Crud("users");
$out = '';

if(i($QUERY,'id')) {
	$subordinates = $sql->getAll("SELECT U.id, U.first_name, U.last_name, U.email, U.phone_no 
			FROM users U 
			INNER JOIN reports_tos R ON U.id=R.user_id 
			WHERE R.manager_id=$QUERY[id]");
	if($subordinates) {
		$out = "<h3>Subordinates</h3><table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>";
		foreach($subordinates as $s) $out .= "<tr><td><a href='users.php?action=edit&amp;id=$s[id]'>$s[id]</a></td><td>$s[first_name] $s[last_name]</td><td>$s[email]</td><td>$s[phone_no]</td></tr>";
		$out .="</table>";
	}

	$managers = $sql->getAll("SELECT U.id, U.first_name, U.last_name, U.email, U.phone_no, R.created_at, R.updated_at
			FROM users U 
			INNER JOIN reports_tos R ON U.id=R.manager_id 
			WHERE R.user_id=$QUERY[id]");
	if($managers) {
		$out .= "<h3>Managers</h3><table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th></tr>";
		foreach($managers as $s) $out .= "<tr><td><a href='users.php?action=edit&amp;id=$s[id]'>$s[id]</a></td><td>$s[first_name] $s[last_name]</td><td>$s[email]</td><td>$s[phone_no]</td></tr>";
		$out .="</table>";
	}


	$groups = $sql->getCol("SELECT role FROM roles INNER JOIN user_role_maps ON role_id=roles.id WHERE user_id=$QUERY[id]");
	$out .= "<h4>Groups : " . implode(", ", $groups) . "</h4>";

	$crud->code['top'] = $out;

}


$crud->render();