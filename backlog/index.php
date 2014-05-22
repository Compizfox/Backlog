<?php
include("include/pages.php");
include("include/menu.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="//netdna.bootstrapcdn.com/bootswatch/3.1.0/slate/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400italic,700,700italic" rel='stylesheet' type='text/css'>
	<link href="stylesheet.css" rel="stylesheet">
	<?=@$css?>
	<title><?="Backlog - $pagename"?></title>
</head>

<body>
	<header>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="h1" >Backlog <small>The ultimate game database</small></div>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<?php
						$menu = new menu(0, $page);
						echo($menu->draw("h"));
						?>
					</ul>
					<form class="navbar-form navbar-right">
						<input type="text" class="form-control" placeholder="Search...">
					</form>
				</div>
			</div>
		</nav>
	</header>

	<div class="container-fluid">
		<div class="row">
			<nav class="col-sm-3 col-md-2 sidebar">
				<ul class="nav nav-sidebar">
					<?php
					$menu = new menu(1, $page);
					echo($menu->draw("v"));
					?>
				</ul>
			</nav>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<?php
				echo("<h1>$pagename</h1>");
				include("pages/$include");
				?>
			</div>
		</div>
	</div>
	
	<footer class="navbar navbar-fixed-bottom">  
        <p class="text-center"><a href="https://github.com/Compizfox/Backlog">Made by Lars Veldcholte</a></p>
    </footer>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.0/js/bootstrap.min.js"></script>
	<?=@$js?>
	<?=@$script?>
</body>
</html>