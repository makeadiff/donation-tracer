<?php
require('common.php');
$html = new HTML;
$result_users = array();
$subordinates = array();
$managers = array();
$all_roles = array();
$roles = array();

$action = i($QUERY,'action');
$user_id = i($QUERY, 'user_id');

if($action == 'Find') {
	$search = array();
	if(i($QUERY, 'id')) $search['id'] = "id=".i($QUERY, 'id');
	if(i($QUERY, 'name')) $search['first_name'] = "first_name LIKE '%" . i($QUERY, 'name') . "%'";
	if(i($QUERY, 'email')) $search['email'] = "email LIKE '%" . i($QUERY, 'email') . "%'";
	if(i($QUERY, 'phone')) $search['phone_no'] = "phone_no LIKE '%" . i($QUERY, 'phone') . "%'";

	if($search) {
		$result_users = $sql->getAll("SELECT * FROM users WHERE " . implode(" AND ", $search));
	}
}

if($action == 'Change Roles') {
	$new_roles = $QUERY['role'];
	$sql->execQuery("DELETE FROM user_role_maps WHERE user_id=$user_id");
	foreach($new_roles as $role) {
		$sql->insert("user_role_maps", array(
			'role_id' => $role,
			'user_id' => $user_id,
			'created_at' => 'NOW()',
			'updated_at' => 'NOW()'
		));
	}
}

if($user_id) {
 	$user = $sql->getAssoc("SELECT * FROM users WHERE id=$user_id");

	$subordinates = $sql->getAll("SELECT U.id, U.first_name, U.last_name, U.email, U.phone_no 
			FROM users U 
			INNER JOIN reports_tos R ON U.id=R.user_id 
			WHERE R.manager_id=$user_id");

	$managers = $sql->getAll("SELECT U.id, U.first_name, U.last_name, U.email, U.phone_no, R.created_at, R.updated_at
			FROM users U 
			INNER JOIN reports_tos R ON U.id=R.manager_id 
			WHERE R.user_id=$user_id");

	$all_roles = $sql->getById("SELECT id,role FROM roles");
	$roles = $sql->getById("SELECT R.id,R.role 
		FROM roles R
		INNER JOIN user_role_maps UR ON UR.role_id=R.id
		WHERE UR.user_id=$user_id");
}
showTop('Assigner');
?>

<h1>Donation Tracer</h1>

<form method="post" class="form-area">
<?php 
$html->buildInput("id");
$html->buildInput("name");
$html->buildInput("email");
$html->buildInput("phone");
$html->buildInput("action", '&nbsp;', 'submit', 'Find');
echo '<br />';

if(!empty($result_users)) {
?>
<table>
	<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Deleted?</th><th>MADApp ID</th></tr>
	<?php foreach($result_users as $u) { ?>
		<tr>
			<td><a href="?user_id=<?php echo $u['id'] ?>"><?php echo $u['id'] ?></a></td>
			<td><?php echo $u['first_name'] ?></td>
			<td><?php echo $u['email'] ?></td>
			<td><?php echo $u['phone_no'] ?></td>
			<td><?php echo $u['city_id'] ?></td>
			<td><?php echo $u['is_deleted'] ?></td>
			<td><?php echo $u['madapp_user_id'] ?></td>
		</tr>
	<?php } ?>
</table>
<?php
}

if($user) echo "<h2>$user_id - $user[first_name] $user[last_name]</h2>";

if($subordinates) { ?>
	<h3>Subordinates</h3>
	<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Action</th></tr>
	<?php foreach($subordinates as $s) { ?>
		<tr><td><a href='users.php?action=edit&amp;id=<?php echo $s['id'] ?>'><?php echo $s['id'] ?></a></td>
			<td><?php echo $s['first_name'] .' '. $s['last_name'] ?></td><td><?php echo $s['email'] ?></td><td><?php echo $s['phone_no'] ?></td>
			<!-- <td><a href="?action=remove_association&user_id=<?php echo $user_id ?>&sub_user_id=<?php echo $s['id'] ?>">Remove This Association</a></td> --></tr>
	<?php } ?>
	</table>
	<?php 
}

if($managers) { ?>
	<h3>Managers</h3>
	<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Action</th></tr>
	<?php foreach($managers as $s) { ?>
		<tr><td><a href='users.php?action=edit&amp;id=<?php echo $s['id'] ?>'><?php echo $s['id'] ?></a></td>
			<td><?php echo $s['first_name'] .' '. $s['last_name'] ?></td><td><?php echo $s['email'] ?></td><td><?php echo $s['phone_no'] ?></td>
			<!-- <td><a href="?action=remove_association&user_id=<?php echo $user_id ?>&manager_user_id=<?php echo $s['id'] ?>">Remove This Association</a></td> --></tr>
	<?php } ?>
	</table>
	<?php
}

if($roles) {
?>
<h3>Groups</h3>
<form action="" method="POST" >
<select name="role[]" multiple="multiple" size="10">
	<?php foreach ($all_roles as $role_id => $role_name) { ?>
	<option value="<?php echo $role_id ?>" <?php if(i($roles, $role_id)) echo 'selected'; ?>><?php echo $role_name ?></option>
	<?php } ?>
</select><br />
<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
<input type="submit" name="action" value="Change Roles" />
</form>

<?php
}
showEnd();

