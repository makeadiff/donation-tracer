<?php
require 'common.php';
/**
 * Purpose : Some people are having issues with signing into old id when donuting. So their donation goes to the old volunteers name. This scirpt lets you change the fundraiser on donations after a given date.
 */

$action = i($QUERY, 'action');

$mistaken_fundraiser_id = i($QUERY, 'mistaken_fundraiser_id');
$actual_fundraiser_id = i($QUERY, 'actual_fundraiser_id');
$mistaken_fundraiser_email = i($QUERY, 'mistaken_fundraiser_email');
$actual_fundraiser_phone = i($QUERY, 'actual_fundraiser_phone');

$output = '';

$change_donations_after = '2017-08-01';

if($action) {
	if($mistaken_fundraiser_email and $actual_fundraiser_phone) {
		$PARAM['mistaken_fundraiser_id'] = $sql->getOne("SELECT id FROM users WHERE email='$mistaken_fundraiser_email'");
		$PARAM['actual_fundraiser_id'] = $sql->getOne("SELECT id FROM users WHERE phone_no='$actual_fundraiser_phone'");

		dump($PARAM);

	} else if($mistaken_fundraiser_id and $actual_fundraiser_id) {
		// Change donations.
		$query['donations'] = "UPDATE donations SET fundraiser_id=$actual_fundraiser_id WHERE fundraiser_id=$mistaken_fundraiser_id AND created_at > '$change_donations_after 00:00:00'";

		// And external_donations
		$query['external_donations'] = "UPDATE external_donations SET fundraiser_id=$actual_fundraiser_id WHERE fundraiser_id=$mistaken_fundraiser_id AND created_at > '$change_donations_after 00:00:00'";

		// Deposits
		$query['deposits'] = "UPDATE deposits SET collected_from_user_id=$actual_fundraiser_id WHERE collected_from_user_id=$mistaken_fundraiser_id AND added_on > '$change_donations_after 00:00:00'";

		// Change the mistaken ID to deleted - so this won't happen again.
		$query['delete_user'] = "UPDATE users SET is_deleted=1 WHERE id=$mistaken_fundraiser_id";

		foreach ($query as $name => $q) {
			$result = $sql->execQuery($q);
			$output .= "Executed '$name' : $result \t($q)<br />\n";
		}
	}
}

showTop('Search and Replace');

$html = new HTML;
?>
<h1>Search and Replace</h1>

<form action="" class="form-area">
<?php
$html->buildInput('mistaken_fundraiser_email');
$html->buildInput('actual_fundraiser_phone');
$html->buildInput("mistaken_fundraiser_id");
$html->buildInput("actual_fundraiser_id");

$html->buildInput("action", '&nbsp;', 'submit', 'Replace');
?>
</form><br />
<?php 
print $output;

showEnd();
