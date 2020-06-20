<!DOCTYPE HTML>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title . (isset($page_title) ? " : $page_title" : '') ?></title>
<link href="<?php echo $config['common_library_url'] ?>assets/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $config['common_library_url'] ?>assets/images/silk_theme.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $config['common_library_url'] ?>bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $config['app_url'] ?>css/style.css" rel="stylesheet" type="text/css" />
<?php echo $css_includes ?>
</head>
<body>
<div id="wrapper" class="container">
<div id="header" class="navbar navbar-fixed-top navbar-inverse" role="navigation">
<div id="nav" class="container">
	<div class="navbar-brand"><a href="<?php echo $config['app_url'] ?>"><?php echo $config['app_name'] ?></a></div>
</div>
</div>
<div id="content" class="container">

<div class="message-area" id="error-message" <?php echo ($QUERY['error']) ? '':'style="display:none;"';?>><?php
	if(!empty($PARAM['error'])) print strip_tags($PARAM['error']); //It comes from the URL
	else print $QUERY['error']; //Its set in the code(validation error or something).
?></div>
<div class="message-area" id="success-message" <?php echo ($QUERY['success']) ? '':'style="display:none;"';?>><?php echo strip_tags(stripslashes($QUERY['success']))?></div>

<?php include(iframe\App::$template->template); ?>

</div>
<div id="footer"></div>
</div>

<script src="<?php echo $config['common_library_url'] ?>bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $config['common_library_url'] ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo $config['app_url'] ?>js/application.js" type="text/javascript"></script>
<?php echo $js_includes; ?>
</body>
</html>
