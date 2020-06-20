<?php
require('common.php');

$html = new iframe\HTML\HTML;
$donation_id = i($QUERY, 'donation_id');
$action = i($QUERY, 'action');
if($action == "Save Finance ID" and i($QUERY, 'donor_id') and i($QUERY, 'donor_finance_id')) {
	$sql->update("Donut_Donor", ['donor_finance_id' => $QUERY['donor_finance_id']], ['id' => $QUERY['donor_id']]);

} elseif($action == "Save Deposit") {
	$sql->update("Donut_Deposit", [
		'deposit_information' 	=> $QUERY['deposit_information'],
		'status'				=> $QUERY['status']
	], ['id' => $QUERY['deposit_id']]);
}

$donation = $sql->getAssoc("SELECT D.id, U.name AS fundraiser, U.id AS fundraiser_user_id, U.email AS fundraiser_email, DON.name AS donor, DON.id AS donor_id,
										D.status, D.amount, D.added_on, D.updated_on, D.updated_by_user_id,
										DON.donor_finance_id
									FROM Donut_Donation D
									INNER JOIN User U ON U.id=D.fundraiser_user_id
									INNER JOIN Donut_Donor DON ON DON.id=D.donor_id
									WHERE D.id=$donation_id");
if(!$donation) die("Can't find any donation with the ID $donation_id");

$donation['deposits'] = $sql->getAll("SELECT D.id, D.added_on, D.reviewed_on, D.status, 
										CFROM.name AS collected_from,CFROM.email AS collected_from_email, D.collected_from_user_id,
										GTO.name AS given_to,GTO.email AS given_to_email, D.given_to_user_id,
										D.deposit_information
									FROM Donut_Deposit D
									INNER JOIN Donut_DonationDeposit DD ON DD.deposit_id=D.id
									INNER JOIN Donut_Donation DON ON DD.donation_id=DON.id
									INNER JOIN User CFROM ON CFROM.id=D.collected_from_user_id
									INNER JOIN User GTO ON GTO.id=D.given_to_user_id
									WHERE DON.id=$donation_id
									ORDER BY added_on DESC");

render();
