<?php
if(!isset($single_user)) $single_user = 1;
require(dirname(dirname(dirname(__FILE__))) . '/commons/common.php');

accessControl([
	'group_name'	=> ['Tech', 'Program Director, Finance']
]);
