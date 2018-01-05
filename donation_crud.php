<?php
require('common.php');
 
$crud = new Crud("donations");
$crud->fields['donation_status']['field_type'] = 'text';
$crud->fields['fundraiser_id']['field_type'] = 'text';
$crud->fields['donour_id']['field_type'] = 'text';

$crud->setListingQuery("SELECT D.id,D.fundraiser_id,D.donour_id,D.donation_status,D.donation_amount,D.created_at,
	U.first_name AS fundraiser, DON.first_name AS donor
	FROM donations D 
	INNER JOIN users U ON U.id=D.fundraiser_id
	INNER JOIN donours DON ON DON.id=D.donour_id");
$crud->setListingFields("id", "fundraiser", "donor", "donation_status", "donation_amount", "created_at");


$crud->setFormFields("id", "fundraiser_id", "donour_id", "donation_status", "donation_amount", "created_at", "updated_by");

$crud->render();