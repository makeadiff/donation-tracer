<?php
require '../common.php';

$user_id_with_issue = 14060;

$all_done = $sql->getAll("SELECT D.id,D.donation_status,D.donation_amount FROM 
	donations D
	INNER JOIN deposits_donations DD ON DD.donation_id=D.id
	INNER JOIN deposits DEP ON DEP.id=DD.deposit_id
	WHERE DEP.given_to_user_id=$user_id_with_issue AND D.donation_status='RECEIPT SENT'");

$total = 0;
foreach($all_done as $don) {
	$is_deposited_to_national = $sql->getOne("SELECT DEP.id
		FROM deposits DEP
		INNER JOIN deposits_donations DD ON DD.deposit_id=DEP.id
		WHERE DEP.given_to_user_id = 13257 AND DD.donation_id = $don[id]");

	if(!$is_deposited_to_national) {
		$total += $don['donation_amount'];
		// print "Fixing $don[id]\n";
		print ("UPDATE donations SET updated_by=$user_id_with_issue , donation_status='DEPOSIT_PENDING' WHERE id=$don[id];\n");
		$sql->execQuery("UPDATE donations SET updated_by=$user_id_with_issue , donation_status='DEPOSIT_PENDING' WHERE id=$don[id]");
	} else {
		// print "Done $don[id]\n";
	}
}

print "Fixed Total: $total\n";


/*
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=9674;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=9676;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=9725;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10014;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10015;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10009;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10010;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10022;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10023;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10021;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10024;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10026;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10027;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10033;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10034;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10035;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10036;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10037;
UPDATE donations SET updated_by=14060 , donation_status='DEPOSIT_PENDING' WHERE id=10038;

 */