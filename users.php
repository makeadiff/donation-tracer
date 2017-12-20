<?php
require('common.php');
 
$crud = new Crud("users");
$crud->fields['first_name']['field_type'] = 'text';
$crud->fields['last_name']['field_type'] = 'text';
$crud->fields['phone_no']['field_type'] = 'text';
$crud->fields['email']['field_type'] = 'text';
$crud->setListingQuery("SELECT * FROM users WHERE is_deleted='0'");
$crud->setListingFields("id", "first_name", "last_name", "email", "phone_no", "city_id", "madapp_user_id", "created_at");
$crud->setFormFields("first_name", "last_name", "email", "phone_no", "city_id", "is_deleted", "madapp_user_id");
$crud->addListDataField("city_id", "cities", "name", "1=1 ORDER BY name"); 
$crud->addField("madapp_user_id", 'MADApp User ID','int');

$out = '';
// $curd->set

if(i($QUERY,'id')) {
	$groups = $sql->getCol("SELECT role FROM roles INNER JOIN user_role_maps ON role_id=roles.id WHERE user_id=$QUERY[id]");
	$out .= "<h4>Groups : " . implode(", ", $groups) . "</h4>";

	$crud->code['top'] = $out;
}

$crud->render();