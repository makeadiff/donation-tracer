<?php
require('common.php');
 
$crud = new Crud("User");
$crud->fields['name']['field_type'] = 'text';
$crud->fields['phone']['field_type'] = 'text';
$crud->fields['email']['field_type'] = 'text';
$crud->setListingQuery("SELECT * FROM User WHERE status='1' AND user_type='volunteer'");
$crud->setListingFields("id", "name", "email", "phone", "city_id", "added_on");
$crud->setFormFields("name", "email", "phone", "city_id", "status");
$crud->addListDataField("city_id", "City", "City", "1=1 ORDER BY name"); 

$out = '';

if(i($QUERY,'id')) {
	$groups = $sql->getCol("SELECT G.name FROM `Group` G INNER JOIN UserGroup UG ON UG.group_id=G.id WHERE UG.user_id=$QUERY[id]");
	$out .= "<h4>Groups : " . implode(", ", $groups) . "</h4>";

	$crud->code['top'] = $out;
}

$crud->render();