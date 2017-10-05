<script type="text/javascript">
var all_users = <?php echo json_encode(array_values($all_users)); ?>;
</script>

<h2>City View</h2>

<form action="" method="POST">
<?php $html->buildInput('city_id', 'City', 'select', $city_id, array('options' => $all_cities)) ?>
<input type="submit" name="action" value="Change" />
</form>

<h3>Finance Fellow</h3>

<ul>
	<?php foreach ($finance_fellows as $user_id => $name) { ?>
		<li><?php echo $name ?></li>
	<?php } ?>
	<li><form action="" method="POST">
<input type="text" name="search" class="auto" placeholder="Name/Email/Phone" />
<input type="hidden" name="user_id" value="0" class="user_id" />
<input type="submit" name="action" value="Make Finance Fellow" />
<input type="hidden" name="city_id" value="<?php echo $city_id ?>" />
<input type="hidden" name="role" value="FC" />
</form></li>
</ul>


<h3>Coaches</h3>

<ul>
	<?php foreach ($coaches as $user_id => $coach) { ?>
		<li><?php echo $coach['name'] ?>
			<ul><?php 
			foreach ($coach['vols'] as $vol_id => $name) { ?>
				<li value="<?php echo $user_id ?>"><?php echo $name ?></li>
			<?php } ?>
			<li><form action="" method="POST">
			<input type="text" name="search" class="auto" placeholder="Name/Email/Phone" />
			<input type="hidden" name="user_id" value="0" class="user_id" />
			<input type="submit" name="action" value="Assign" />
			<input type="hidden" name="city_id" value="<?php echo $city_id ?>" />
			<input type="hidden" name="manager_id" value="<?php echo $user_id ?>" />
			</form></li>
			</ul>
		</li>
	<?php } ?>
	<li><form action="" method="POST">
<input type="text" name="search" class="auto" id="coach_search" placeholder="Name/Email/Phone" />
<input type="hidden" name="user_id" value="0" class="user_id" />
<input type="submit" name="action" value="Make Coach" />
<input type="hidden" name="city_id" value="<?php echo $city_id ?>" />
<input type="hidden" name="role" value="POC" />
</form></li>
</ul>


<h3>Unassigned Volunteers</h3>

<ul>
<?php foreach ($unassigned_volunteers as $user_id => $vol) { ?>
	<li><?php echo $vol['name'] ?></li>
<?php } ?>
</ul>


