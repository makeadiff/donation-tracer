<?php
//Configuration file for iFrame
$config = array(
	'site_title'	=> 'Donation Tracer',
	'db_database'	=> ($_SERVER['HTTP_HOST'] == 'makeadiff.in') ? 'makeadiff_cfrapp' : 'Project_Donut',
) + $config_data;
$config['site_home'] = $config_data['site_home'] . 'apps/debug-tools/donation-tracer/';
