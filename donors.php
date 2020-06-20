<?php
require('common.php');
 
$crud = new Crud("Donut_Donor");
$crud->addField('added_by_user_id', 'Added By', 'int', []);
$crud->render();
