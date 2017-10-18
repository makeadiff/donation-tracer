<?php
require('common.php');

showTop('Donation Tracer');

if(i($QUERY, 'action')) {
	$crud = new Crud("donations");
	$crud->save_states[] = 'action';

	if(i($QUERY, 'action') == 'Search Donuts' or i($QUERY, 'action') == 'Search Externals') {
		$wheres = array();
		if(!empty($_REQUEST['donation_id'])) {
			$wheres[] = "(D.id='$_REQUEST[donation_id]')";
			$crud->save_states[] = 'donation_id';
		}

		if(!empty($_REQUEST['donor_name'])) {
			$name_parts = explode(" ", $_REQUEST['donor_name']);
			$wheres[] = "((DN.first_name LIKE '$name_parts[0]%' AND DN.last_name LIKE '$name_parts[1]%') OR DN.first_name LIKE '$_REQUEST[donor_name]%')";
			$crud->save_states[] = 'donor_name';
		}

		if(!empty($_REQUEST['donor_phone'])) {
			$name_parts = explode(" ", $_REQUEST['donor_phone']);
			$wheres[] = "(DN.phone_no='$_REQUEST[donor_phone]')";
			$crud->save_states[] = 'donor_phone';
		}

		if(!empty($_REQUEST['donor_email'])) {
			$name_parts = explode(" ", $_REQUEST['donor_email']);
			$wheres[] = "(DN.email_id='$_REQUEST[donor_email]')";
			$crud->save_states[] = 'donor_email';
		}

		if(!empty($_REQUEST['user_name'])) {
			$name_parts = explode(" ", $_REQUEST['user_name']);
			$wheres[] = "((U.first_name LIKE '$name_parts[0]%' AND U.last_name LIKE '$name_parts[1]%') OR U.first_name LIKE '$_REQUEST[user_name]%')";
			$crud->save_states[] = 'user_name';
		}

		if(!empty($_REQUEST['user_phone'])) {
			$wheres[] = "(U.phone_no='$_REQUEST[user_phone]')";
			$crud->save_states[] = 'user_phone';
		}
		if(!empty($_REQUEST['user_id'])) {
			$wheres[] = "(U.id='$_REQUEST[user_id]')";
			$crud->save_states[] = 'user_id';
		}

		if(!empty($_REQUEST['user_email'])) {
			$wheres[] = "(U.email='$_REQUEST[user_email]')";
			$crud->save_states[] = 'user_email';
		}

		if(!empty($_REQUEST['poc_name'])) {
			$name_parts = explode(" ", $_REQUEST['poc_name']);
			$wheres[] = "((U.first_name LIKE '$name_parts[0]%' AND U.last_name LIKE '$name_parts[1]%') OR U.first_name LIKE '$_REQUEST[poc_name]%')";
			$crud->save_states[] = 'poc_name';
		}

		if(!empty($_REQUEST['amount'])) {
			$name_parts = explode(" ", $_REQUEST['amount']);
			$wheres[] = "(D.donation_amount = '$_REQUEST[amount]%')";
			$crud->save_states[] = 'amount';
		}

		if(i($QUERY, 'action') == 'Search Donuts') {
			$table = 'donations';
			$donor_id = 'donour_id';
			$more_fields = '';
		} else {
			$table = 'external_donations';
			$donor_id = 'donor_id';
			$more_fields = 'D.amount AS donation_amount, D.donor_id AS donour_id, ';
		}

		$query = "SELECT 	D.*, $more_fields
							DN.first_name AS donor_first_name,DN.last_name  AS donor_last_name, DN.email_id, DN.phone_no,
							U.first_name,U.last_name, U.email, U.phone_no, C.name AS city_name
					FROM $table D 
					INNER JOIN donours DN ON DN.id=D.$donor_id
					INNER JOIN users U ON U.id=D.fundraiser_id
					INNER JOIN cities C ON U.city_id=C.id
					WHERE " . implode(" AND ", $wheres);

		// $data = $sql->getAll($query);
		// print "<pre>$query</pre>";
		// dump($data);

		$crud->setListingQuery($query);
		$crud->addField('city_name', 'City', 'text', array(), array('text'=>'$row["city_name"]'));
		$crud->addField('fundraiser_id', 'FundRaiser', 'int', array(), 
			array('url'=>'"users.php?action=edit&amp;id=$row[fundraiser_id]"', 'text'=>'$row["first_name"]. " " . $row["last_name"]'),'text', 'url');
		$crud->addField('donour_id', 'Donor', 'int', array(), 
			array('url'=>'"donors.php?action=edit&amp;id=$row[donour_id]"', 'text'=>'$row["donor_first_name"]. " " . $row["donor_last_name"]'),'text', 'url');
		$crud->addField('updated_by', 'Updater', 'int', array(), 
			array('url'=>'"users.php?action=edit&amp;id=$row[updated_by]"', 'text'=>'$row["first_name"]. " " . $row["last_name"]'),'text', 'url');

		$crud->setListingFields('id', 'donour_id', 'fundraiser_id', 'donation_status', 'donation_amount', 'created_at', 'updated_at', 'updated_by', 'source_id', 'city_name');
		
	}

	$crud->printAction();



} else {
?>
<h1>Donation Tracer</h1>

<form method="post" class="form-area">
<fieldset>
<legend>Donor Info</legend>
<label for="donor_name">Donor Name</label>
<input type="text" name="donor_name" id="donor_name" value="" /><br />
<label for="donor_phone">Donor Phone</label>
<input type="text" name="donor_phone" id="donor_phone" value="" /><br />
<label for="donor_email">Donor Email</label>
<input type="text" name="donor_email" id="donor_email" value="" /><br />
</fieldset>

<fieldset>
<legend>User Info</legend>
<label for="user_name">User Name</label>
<input type="text" name="user_name" id="user_name" value="" /><br />

<label for="user_phone">User Phone Number</label>
<input type="text" name="user_phone" id="user_phone" value="" /><br />

<label for="user_email">User Email</label>
<input type="text" name="user_email" id="user_email" value="" /><br />

<label for="user_id">User ID</label>
<input type="text" name="user_id" id="user_id" value="" /><br />

<label for="poc_name">POC Name</label>
<input type="text" name="poc_name" id="poc_name" value="" /><br />
</fieldset>

<fieldset>
<legend>Donation Info</legend>
<label for="donation_id">Donation ID</label>
<input type="text" name="donation_id" id="donation_id" value="" /><br />

<label for="amount">Amount</label>
<input type="text" name="amount" id="amount" value="" /><br />
</fieldset>

<input type="submit" value="Search Donuts" name="action" />
<input type="submit" value="Search Externals" name="action" />
</form>

<?php
}

showEnd();
