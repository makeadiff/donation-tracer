<?php
if(!isset($single_user)) $single_user = 1;
require(dirname(dirname(__DIR__)) . '/commons/common.php');
// iframe\App::$template->css_folder = 'assets/css';
// iframe\App::$template->js_folder = 'assets/js';

accessControl([
	'group_name'	=> ['Tech', 'Program Director, Finance']
]);
