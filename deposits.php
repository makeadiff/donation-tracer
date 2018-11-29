<?php
require('common.php');
 
$crud = new Crud("Donut_Deposit");

$where = array('1' => '1=1');
if(i($QUERY, 'given_to_user_id')) $where['given_to_user_id'] = "D.given_to_user_id = " . i($QUERY, 'given_to_user_id');
if(i($QUERY, 'collected_from_user_id')) $where['collected_from_user_id'] = "D.collected_from_user_id = " . i($QUERY, 'collected_from_user_id');
if(i($QUERY, 'status')) $where['status'] = "D.status = " . i($QUERY, 'status');
if(i($QUERY, 'deposit_id')) $where['deposit_id'] = "D.id = " . i($QUERY, 'deposit_id');

print "SELECT D.id,D.added_on,D.reviewed_on,D.amount,D.status, D.collected_from_user_id, D.given_to_user_id,
		C.name AS collected_from, G.name AS given_to, GROUP_CONCAT(DD.donation_id SEPARATOR ', ') AS donations
	FROM Donut_Deposit D 
	INNER JOIN Donut_DonationDeposit DD ON DD.deposit_id=D.id
	INNER JOIN User G ON G.id=D.given_to_user_id
	INNER JOIN User C ON C.id=D.collected_from_user_id
	WHERE " . implode(' AND ', array_values($where)) . "
	GROUP BY DD.deposit_id";
$crud->setListingQuery("SELECT D.id,D.added_on,D.reviewed_on,D.amount,D.status, D.collected_from_user_id, D.given_to_user_id,
		C.name AS collected_from, G.name AS given_to, GROUP_CONCAT(DD.donation_id SEPARATOR ', ') AS donations
	FROM Donut_Deposit D 
	INNER JOIN Donut_DonationDeposit DD ON DD.deposit_id=D.id
	INNER JOIN User G ON G.id=D.given_to_user_id
	INNER JOIN User C ON C.id=D.collected_from_user_id
	WHERE " . implode(' AND ', array_values($where)) . "
	GROUP BY DD.deposit_id");
$crud->setListingFields("id", "donations", "added_on", "reviewed_on", "collected_from", "given_to", "amount", "status");

// Change content based on a callback function.
$crud->addField('donations', 'Donations', 'varchar', [], array('function'=>'linkDonations'), 'function', 'function');
		
$crud->render();

function linkDonations($donations) {
	$donation_ids = explode(", ", $donations);
	$links = array();
	foreach ($donation_ids as $id) $links[] = "<a href='donation.php?donation_id=$id'>$id</a>";

	return implode(", ", $links);
}
