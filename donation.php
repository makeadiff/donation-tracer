<?php
require('common.php');

$donation_id = i($QUERY, 'donation_id');

$donation = $sql->getAssoc("SELECT D.id, U.name AS fundraiser, U.id AS fundraiser_user_id, U.email AS fundraiser_email, DON.name AS donor, DON.id AS donor_id,
										D.status, D.amount, D.added_on, D.updated_on, D.updated_by_user_id
									FROM Donut_Donation D
									INNER JOIN User U ON U.id=D.fundraiser_user_id
									INNER JOIN Donut_Donor DON ON DON.id=D.donor_id
									WHERE D.id=$donation_id");
if(!$donation) die("Can't find any donation with the ID $donation_id");

$donation['deposits'] = $sql->getAll("SELECT D.id, D.added_on, D.reviewed_on, D.status, 
										CFROM.name AS collected_from,CFROM.email AS collected_from_email, D.collected_from_user_id,
										GTO.name AS given_to,GTO.email AS given_to_email, D.given_to_user_id
									FROM Donut_Deposit D
									INNER JOIN Donut_DonationDeposit DD ON DD.deposit_id=D.id
									INNER JOIN Donut_Donation DON ON DD.donation_id=DON.id
									INNER JOIN User CFROM ON CFROM.id=D.collected_from_user_id
									INNER JOIN User GTO ON GTO.id=D.given_to_user_id
									WHERE DON.id=$donation_id
									ORDER BY added_on");

render();
