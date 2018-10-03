<?php
require('common.php');
 
$crud = new Crud("deposits");

$where = array('1' => '1=1');
if(i($QUERY, 'given_to_user_id')) $where['given_to_user_id'] = "D.given_to_user_id = " . i($QUERY, 'given_to_user_id');
if(i($QUERY, 'collected_from_user_id')) $where['collected_from_user_id'] = "D.collected_from_user_id = " . i($QUERY, 'collected_from_user_id');
if(i($QUERY, 'status')) $where['status'] = "D.status = " . i($QUERY, 'status');

$crud->setListingQuery("SELECT D.id,D.added_on,D.reviewed_on,D.amount,D.status, D.collected_from_user_id, D.given_to_user_id,
		C.first_name AS collected_from, G.first_name AS given_to, GROUP_CONCAT(DD.donation_id SEPARATOR ', ') AS donations
	FROM deposits D 
	INNER JOIN deposits_donations DD ON DD.deposit_id=D.id
	-- INNER JOIN donations DO ON DD.donation_id=D.id
	INNER JOIN users G ON G.id=D.given_to_user_id
	INNER JOIN users C ON C.id=D.collected_from_user_id
	WHERE " . implode(' AND ', array_values($where)) . "
	GROUP BY DD.deposit_id");
$crud->setListingFields("id", "donations", "added_on", "reviewed_on", "collected_from", "given_to", "amount", "status");

// Change content based on a callback function.
$crud->addField('donations', 'Donations', 'varchar', array(), 
		array('function'=>'linkDonations'), 'function', 'function');
		
$crud->render();

function linkDonations($donations) {
	$donation_ids = explode(", ", $donations);
	$links = array();
	foreach ($donation_ids as $id) $links[] = "<a href='donation.php?donation_id=$id'>$id</a>";

	return implode(", ", $links);
}
