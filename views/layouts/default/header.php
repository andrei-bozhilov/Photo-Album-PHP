<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Photo-Album</title>
		<meta name="description" content="Photo Album">
		<meta name="viewport" content="width=device-width">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,300' rel='stylesheet' type='text/css'>
		<link rel="stylesheet"  type="text/css" href="/content/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/content/styles/styles.css">
		<link rel="stylesheet" type="text/css" href="/content/styles/slider.css">
		<script type="application/javascript" src="/content/bower_components/jquery/dist/jquery.js"></script>
		<script type="application/javascript" src="/content/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script type="application/javascript" src="/content/bower_components/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>
		<script src="/content/scripts/actions.js"></script>
		<script src="/content/scripts/domManipulations.js"></script>
		<script src="/content/scripts/noty.js"></script>
		<script src="/content/scripts/main-script.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-default nav-app navbar-fixed-top" id="main-header"> 
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display   navbar-fixed-top-->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/home"> <img src="/content/images/logo.png"></a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="<?php if($this->location == "home") echo "active"?>">
							<a href="/home/index">Home</a>
						</li>
						<li class="<?php if($this->sub_location == "users") echo "active"?>">
							<a href="/rank/users">Best users</a>
						</li>
						<li class="<?php if($this->sub_location == "albums") echo "active"?>">
							<a href="/rank/albums">Best Albums</a>
						</li>
							<li class="<?php if($this->sub_location == "pictures") echo "active"?>">
							<a href="/rank/pictures">Best Pictures</a>
						</li>
					<?php if($this->isLoggedIn()) : ?>
						<li class="<?php if($this->location == "my_albums") echo "active"?>">
							<a href="/user/index">My Albums</a>
						</li>
						<?php endif; ?>
					</ul>
					<!--<form class="navbar-form navbar-left" role="search">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Search for...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button">
									Go!
								</button> </span>
						</div>
					</form>-->
					<ul class="nav navbar-nav navbar-right">
						<?php if($this->isLoggedIn()) : ?>
						<form method="POST" action="/account/logout" class="form-inline">
							<div class="form-group">
							<div class="form-control"><?php echo htmlspecialchars($this -> getUsername()); ?></div>
							</div>
							<input type="submit" class="btn btn-danger" value="Logout" />
						</form>
						
						<?php else : ?>
						   <li class="<?php if($this->location == "login") echo "active"?>">
							<a href="/account/login">Login</a>
						</li>
						<li class="<?php if($this->location == "register") echo "active"?>">
							<a href="/account/register">Register</a>
						</li>
						<?php endif; ?>
						
					</ul>
				</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
		</nav>
		<?php
		include_once ('views/layouts/messages.php');
		?>
		<div id="container">
			<div id="pusher" style="margin-top: 80px">

			</div>
			<div class="container">
				<div class="row">
