<?php
require('common.php');

/// Purpose: A tool to quickly assign Finance Fellows and Coaches to any city with hirarchy(hirarcy is depricated thanks to deposit structure.)

$html = new HTML;
$city_id = i($QUERY, 'city_id', 25);
$role_ids = array('FC' => 8, 'POC' => 9, 'Volunteer' => 10);
$action = i($QUERY, 'action');

$all_cities = $sql->getById("SELECT id,name FROM cities");

if($action == 'Make Coach' or $action == 'Make Finance Fellow') {
	$user_id = i($QUERY, 'user_id');
	$role = i($QUERY, 'role');
	$role_id = $role_ids[$role];

	$exist = $sql->getOne("SELECT id FROM user_role_maps WHERE user_id=$user_id AND role_id=$role_id");

	if(!$exist) {
		$sql->insert("user_role_maps", array(
			'user_id'	=> $user_id,
			'role_id'	=> $role_id,
			'created_at'=> 'NOW()',
			'updated_at'=> 'NOW()',
		));
	}
} elseif ($action == 'Assign') {
	$user_id = i($QUERY, 'user_id');
	$manager_id = i($QUERY, 'manager_id');

	$exist = $sql->getOne("SELECT user_id FROM reports_tos WHERE user_id=$user_id AND manager_id=$manager_id");

	if(!$exist) {
		$sql->insert("reports_tos", array(
			'user_id'	=> $user_id,
			'manager_id'	=> $manager_id,
			'created_at'=> 'NOW()',
			'updated_at'=> 'NOW()',
		));
	}
}

$all_users = $sql->getById("SELECT U.id,U.first_name AS name,U.email,U.phone_no AS phone 
								FROM users U 
								WHERE U.is_deleted='0' AND U.city_id=$city_id");
$unassigned_volunteers = $all_users;

$finance_fellows = $sql->getById("SELECT U.id,U.first_name AS name FROM users U 
	INNER JOIN user_role_maps URM ON URM.user_id=U.id
	WHERE U.is_deleted='0' AND U.city_id=$city_id AND URM.role_id=" . $role_ids['FC']);

$coaches = $sql->getById("SELECT U.id,U.first_name AS name,U.email FROM users U 
	INNER JOIN user_role_maps URM ON URM.user_id=U.id
	WHERE U.is_deleted='0' AND U.city_id=$city_id AND URM.role_id=" . $role_ids['POC']);

foreach ($coaches as $coach_id => $coach_name) {
	$coaches[$coach_id]['vols'] = $sql->getById("SELECT  U.id,U.first_name AS name FROM users U 
		INNER JOIN reports_tos RT ON RT.user_id=U.id
		WHERE U.is_deleted='0' AND U.city_id=$city_id AND RT.manager_id=$coach_id "); // INNER JOIN user_role_maps URM ON URM.user_id=U.id AND URM.role_id=" . $role_ids['Volunteer']
	
	foreach ($coaches[$coach_id]['vols'] as $vol_id => $vol) {
		unset($unassigned_volunteers[$vol_id]);
	}

}

render();