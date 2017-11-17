<?php
/**
 * Purpose: There was a bug - when FCs approve a deposit that a volunteer handed to them(skipping the coach(or FC was the coach)), the status remained unchanged. This will find such donations and update the status.
 */
require '../common.php';

// Find all dontations where deposit status is approved by FC.

$donations = $sql->getAll("SELECT DISTINCT D.id, DEP.given_to_user_id
	FROM donations D 
	INNER JOIN deposits_donations DD ON DD.donation_id=D.id
	INNER JOIN deposits DEP ON DEP.id=DD.deposit_id
	INNER JOIN users U ON U.id=DEP.given_to_user_id
	INNER JOIN user_role_maps URM ON URM.user_id=U.id
	WHERE URM.role_id=8 AND DEP.status='approved' AND 
		(D.donation_status='HAND_OVER_TO_FC_PENDING' OR D.donation_status='TO_BE_APPROVED_BY_POC')"); 

// Change all donation's status to DEPOSIT_PENDING
$affected = 0;
foreach ($donations as $don) {
	$affected += $sql->execQuery("UPDATE donations SET donation_status='DEPOSIT_PENDING', updated_by=$don[given_to_user_id], updated_at=NOW() WHERE id=$don[id]");
}

echo "Total Donations: " . count($donations);
echo "<br />Changed : " . $affected . '<br /><br />';
dump($donations);
