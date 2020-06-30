<form action="donation.php" method="get">
	<h3>Donation ID : <input type="text" name="donation_id" value="<?php echo $donation['id'] ?>" size="5" /> - <?php echo $donation['amount'] ?> Rs</h3>
	<input type="submit" value="Go" name="action" class="btn btn-success" />
</form><br />

<?php
$deposit_status = [
	'pending'	=> 'Pending for Approval', 
	'approved'	=> 'Approved', 
	'rejected'	=> 'Rejected'
];
?>

<table>
	<tr><td width="150">ID</td><td><a href="donation_crud.php?action=edit&id=<?php echo $donation['id'] ?>"><?php echo $donation['id'] ?></a></td></tr>
	<tr><td>Amount</td><td><form action="donation.php" method="post">
								<?php
								$html->buildInput('donation_id', '', 'hidden', $donation['id']);
								$html->buildInput('amount', '', 'text', $donation['amount']);
								$html->buildInput('action', '', 'submit', 'Save Amount', ['class' => 'btn btn-primary']); ?>
							</form></td></tr>
	<tr><td>Fundraiser</td><td><a href="user.php?action=edit&id=<?php echo $donation['fundraiser_user_id'] ?>"><?php 
				echo $donation['fundraiser'] . ' / ' . $donation['fundraiser_email'] ?></a></td></tr>
	<tr><td>Donor</td><td><a href="donors.php?action=edit&id=<?php echo $donation['donor_id'] ?>"><?php echo $donation['donor'] ?></a></td></tr>
	<tr><td>Status</td><td><?php echo $donation['status'] ?></td></tr>
	<tr><td>Updated By</td><td><?php echo $donation['updated_by_user_id'] ?></td></tr>
	<tr><td>Created On</td><td><?php echo date($config['time_format_php'], strtotime($donation['added_on'])) ?></td></tr>
	<tr><td>Updated On</td><td><?php echo date($config['time_format_php'], strtotime($donation['updated_on'])) ?></td></tr>

	<tr><td>Deposits</td><td>
		<?php foreach ($donation['deposits'] as $dep) { ?>
			<form action="donation.php" method="post">
			<table border="1">
				<tr><td width="150">Collected From</td><td><a href="users.php?action=edit&id=<?php echo $dep['collected_from_user_id'] ?>"><?php echo $dep['collected_from'] ?></a>
					<?php echo $dep['collected_from_email'] ?></td></tr>
				<tr><td>Given To</td><td><a href="users.php?action=edit&id=<?php echo $dep['given_to_user_id'] ?>"><?php echo $dep['given_to'] ?></a>
					<?php echo $dep['given_to_email'] ?></td></tr>
				<tr><td>Status</td><td><?php $html->buildInput('status', '', 'select', $dep['status'], ['options' => $deposit_status]) ?></td></tr>
				<tr><td>Deposit Information</td><td><?php $html->buildInput('deposit_information', '', 'text', $dep['deposit_information']) ?></td></tr>
				<tr><td></td><td><?php $html->buildInput('action', '', 'submit', 'Save Deposit', ['class' => 'btn-sm btn-primary']) ?></td></tr>
				<tr><td>Added On</td><td><?php echo $dep['added_on'] ?></td></tr>
				<tr><td>Reviewed On</td><td><?php echo $dep['reviewed_on'] ?></td></tr>
				<tr><td>Deposit ID</td><td><?php echo $dep['id'] ?></td></tr>
			</table>
			<input type="hidden" name="donation_id" value="<?php echo $donation['id'] ?>" />
			<input type="hidden" name="deposit_id" value="<?php echo $dep['id'] ?>" />
			</form>
		<?php } ?>
	</td></tr>
	<tr><td><br /></td></tr>

	<tr><td><strong>Actions</strong></td><td>
		<!-- <a class="ajaxify with-icon delete confirm" href="index.php?action=delete&select_row[]=<?php echo $donation['id'] ?>">Delete</a> |  -->
			<a class="ajaxify with-icon edit" href="index.php?action=edit&id=<?php echo $donation['id'] ?>">Edit</a></td></tr>
	<tr><td>Donor Salesforce ID</td>
		<td><form action="donation.php" method="post">
				<input type="hidden" name="donation_id" value="<?php echo $donation['id'] ?>" />
				<input type="hidden" name="donor_id" value="<?php echo $donation['donor_id'] ?>" />
				<input type="text" name="donor_finance_id" value="<?php echo $donation['donor_finance_id'] ?>" />
				<input type="submit" name="action" value="Save Finance ID" class="btn btn-primary" />
			</form></td></tr>
	<tr><td>Collected by National Account</td><td><form action="donation.php" method="post">
				<input type="hidden" name="donation_id" value="<?php echo $donation['id'] ?>" />
				<input type="submit" name="action" value="Mark as Collected" class="btn btn-primary" />
			</form>
			This will automatically create a deposit from the final deposited person to national office.</td></tr>
</table>