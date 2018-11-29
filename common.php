<?php
if(!isset($single_user)) $single_user = 1;
require(dirname(dirname(dirname(__FILE__))) . '/common/common.php');

accessControl([
	'group_name'	=> 'Tech'
]);