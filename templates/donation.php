
<h3>Donation ID : <?php echo $donation['id'] ?> - <?php echo $donation['donation_amount'] ?> Rs</h3>

<table>
	<tr><td>ID</td><td><a href="donation_crud.php?action=edit&id=<?php echo $donation['id'] ?>"><?php echo $donation['id'] ?></a></td></tr>
	<tr><td>Amount</td><td><?php echo $donation['donation_amount'] ?></td></tr>
	<tr><td>Fundraiser</td><td><a href="users.php?action=edit&id=<?php echo $donation['fundraiser_id'] ?>"><?php echo $donation['fundraiser'] . '/' . $donation['fundraiser_email'] ?></a></td></tr>
	<tr><td>Donor</td><td><a href="donors.php?action=edit&id=<?php echo $donation['donor_id'] ?>"><?php echo $donation['donor'] ?></a></td></tr>
	<tr><td>Status</td><td><?php echo $donation['donation_status'] ?></td></tr>
	<tr><td>Updated By</td><td><?php echo $donation['updated_by'] ?></td></tr>
	<tr><td>Created On</td><td><?php echo date($config['time_format_php'], strtotime($donation['created_at'])) ?></td></tr>
	<tr><td>Updated On</td><td><?php echo date($config['time_format_php'], strtotime($donation['updated_at'])) ?></td></tr>
	<tr><td>Deposits</td><td>
		<?php foreach ($donation['deposits'] as $dep) { ?>
			<table border="1">
				<tr><td width="150">Collected From</td><td><a href="users.php?action=edit&id=<?php echo $dep['collected_from_user_id'] ?>"><?php echo $dep['collected_from'] ?></a>
					(<?php foreach ($dep['collected_from_groups'] as $role_id) { echo $all_roles[$role_id] . ','; } ?>)
					<?php echo $dep['collected_from_email'] ?></td></tr>
				<tr><td>Given To</td><td><a href="users.php?action=edit&id=<?php echo $dep['given_to_user_id'] ?>"><?php echo $dep['given_to'] ?></a>
					(<?php foreach ($dep['given_to_groups'] as $role_id) { echo $all_roles[$role_id] . ','; } ?>)
					<?php echo $dep['given_to_email'] ?></td></tr>
				<tr><td>Status</td><td><?php echo $dep['status'] ?></td></tr>
				<tr><td>Added On</td><td><?php echo $dep['added_on'] ?></td></tr>
				<tr><td>Reviewed On</td><td><?php echo $dep['reviewed_on'] ?></td></tr>
				<tr><td>Deposit ID</td><td><?php echo $dep['id'] ?></td></tr>
			</table>
		<?php } ?>
	</td></tr>
</table>