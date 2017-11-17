<?php
require('common.php');

$donation_id = i($QUERY, 'donation_id');
$all_roles = $sql->getById("SELECT id,role FROM roles");
$donation = $sql->getAssoc("SELECT D.id, U.first_name AS fundraiser, U.id AS fundraiser_id, U.email AS fundraiser_email, DON.first_name AS donor, DON.id AS donor_id,
										D.donation_status, D.donation_amount, D.created_at, D.updated_at
									FROM donations D
									INNER JOIN users U ON U.id=D.fundraiser_id
									INNER JOIN donours DON ON DON.id=D.donour_id
									WHERE D.id=$donation_id");
$donation['deposits'] = $sql->getAll("SELECT D.id, D.added_on, D.reviewed_on, D.status, 
										CFROM.first_name AS collected_from,CFROM.email AS collected_from_email, D.collected_from_user_id,
										GTO.first_name AS given_to,GTO.email AS given_to_email, D.given_to_user_id
									FROM deposits D
									INNER JOIN deposits_donations DD ON DD.deposit_id=D.id
									INNER JOIN users CFROM ON CFROM.id=D.collected_from_user_id
									INNER JOIN users GTO ON GTO.id=D.given_to_user_id
									WHERE DD.donation_id=$donation_id
									ORDER BY added_on");

foreach ($donation['deposits'] as $key => $dep) {
	$cfui_roles = $sql->getCol("SELECT role_id FROM user_role_maps WHERE user_id = $dep[collected_from_user_id]");
	$gtui_roles = $sql->getCol("SELECT role_id FROM user_role_maps WHERE user_id = $dep[given_to_user_id]");
	$donation['deposits'][$key]['collected_from_groups'] = $cfui_roles;
	$donation['deposits'][$key]['given_to_groups'] = $gtui_roles;
}

render();
