<?php
require('common.php');

showTop('Donation Tracer');

if(i($QUERY, 'action')) {
	$crud = new iframe\iframe\Crud("Donut_Donation");
	$crud->addField('fundraiser_user_id', 'Fund Raiser ID', 'int');
	$crud->addField('donor_id', 'Donor ID', 'int');
	$crud->addField('with_user_id', 'With User ID', 'int');
	$crud->addField('updated_by_user_id', 'Updater User ID', 'int');
	$crud->save_states[] = 'action';

	if(i($QUERY, 'action') == 'Search') {
		$wheres = [];
		if(!empty($_REQUEST['donation_id'])) {
			$wheres[] = "(D.id='$_REQUEST[donation_id]')";
			$crud->save_states[] = 'donation_id';
		}

		if(!empty($_REQUEST['donor_name'])) {
			$name_parts = explode(" ", $_REQUEST['donor_name']);
			$wheres[] = "(DN.name LIKE '%$_REQUEST[donor_name]%')";
			$crud->save_states[] = 'donor_name';
		}

		if(!empty($_REQUEST['donor_phone'])) {
			$name_parts = explode(" ", $_REQUEST['donor_phone']);
			$wheres[] = "(DN.phone = '$_REQUEST[donor_phone]')";
			$crud->save_states[] = 'donor_phone';
		}

		if(!empty($_REQUEST['donor_email'])) {
			$name_parts = explode(" ", $_REQUEST['donor_email']);
			$wheres[] = "(DN.email = '$_REQUEST[donor_email]')";
			$crud->save_states[] = 'donor_email';
		}

		if(!empty($_REQUEST['user_name'])) {
			$name_parts = explode(" ", $_REQUEST['user_name']);
			$wheres[] = "(U.name LIKE '%$_REQUEST[user_name]%')";
			$crud->save_states[] = 'user_name';
		}

		if(!empty($_REQUEST['user_phone'])) {
			$wheres[] = "(U.phone = '$_REQUEST[user_phone]')";
			$crud->save_states[] = 'user_phone';
		}
		if(!empty($_REQUEST['user_id'])) {
			$wheres[] = "(U.id='$_REQUEST[user_id]')";
			$crud->save_states[] = 'user_id';
		}

		if(!empty($_REQUEST['user_email'])) {
			$wheres[] = "(U.email = '$_REQUEST[user_email]' OR U.mad_email = '$_REQUEST[user_email]')";
			$crud->save_states[] = 'user_email';
		}

		if(!empty($_REQUEST['amount'])) {
			$name_parts = explode(" ", $_REQUEST['amount']);
			$wheres[] = "(D.amount = '$_REQUEST[amount]%')";
			$crud->save_states[] = 'amount';
		}

		if(i($QUERY, 'action') == 'Search') {
			$table = 'Donut_Donation';
			$donor_id = 'donour_id';
			$more_fields = '';
		}

		$query = "SELECT 	D.*, $more_fields
							DN.name AS donor_name, DN.email AS donor_email, DN.phone AS donor_phone,
							U.name, U.email, U.phone, C.name AS city_name
					FROM $table D 
					INNER JOIN Donut_Donor DN ON DN.id=D.donor_id
					INNER JOIN User U ON U.id=D.fundraiser_user_id
					INNER JOIN City C ON U.city_id=C.id
					WHERE " . implode(" AND ", $wheres);
		// print $query; exit;

		// $data = $sql->getAll($query);
		// print "<pre>$query</pre>";
		// dump($data);

		$crud->setListingQuery($query);
		$crud->addField('id', 'ID', 'int', [], ['url'=>'"donation.php?donation_id=$row[id]"', 'text'=>'$row["id"]'],'text', 'url');
		$crud->addField('city_name', 'City', 'text', [], ['text'=> '$row["city_name"]']);
		$crud->addField('status', 'Status', 'text');
		$crud->addField('fundraiser_user_id', 'FundRaiser', 'int', [], ['url'=>'"user.php?action=edit&amp;id=$row[fundraiser_user_id]"', 'text'=>'$row["name"]'],'text', 'url');
		$crud->addField('donour_id', 'Donor', 'int', [], ['url'=>'"donors.php?action=edit&amp;id=$row[donor_id]"', 'text'=>'$row["donor_name"]'],'text', 'url');
		$crud->addField('updated_by_user_id', 'Updater', 'int', [], ['url'=>'"users.php?action=edit&amp;id=$row[updated_by_user_id]"', 'text'=>'$row["name"]'],'text', 'url');

		$crud->setListingFields('id', 'donour_id', 'fundraiser_user_id', 'status', 'amount', 'added_on', 'updated_on', 'updated_by_user_id', 'city_name');
		
		$crud->allow['delete'] = false;
		$crud->allow['bulk_operations'] = false;
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

</fieldset>

<fieldset>
<legend>Donation Info</legend>
<label for="donation_id">Donation ID</label>
<input type="text" name="donation_id" id="donation_id" value="" /><br />

<label for="amount">Amount</label>
<input type="text" name="amount" id="amount" value="" /><br />
</fieldset>

<input type="submit" value="Search" name="action" />
</form>

<?php
}

showEnd();
