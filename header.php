<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="BantuUMKM">
	<meta name="author" content="Wahyu Amirulloh">
	<meta name="keywords" content="wordpress">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head() ?>
</head>
<body>
	<header>
		<div class="brand">
			<img src="<?php echo get_template_directory_uri() ?>/assets/logo/logo.png">
			<h2 id="name">Bantu UMKM</h2>
		</div>
		<div class="nav" id="navbar">
			<ul>
				<a href="#">
					<li>Beranda</li>
				</a>
				<a href="#">
					<li>Produk</li>					
				</a>
				<a href="#">
					<li>Blog</li>
				</a>
				<a href="#">
					<li>Hubungi Kami</li>
				</a>
				<button id="nav-button-close">
					<li>X</li>
				</button>
			</ul>
		</div>
		<div class="nav-button" id="nav-open">
			<button id="nav-button-open">☰</button>
		</div>
	</header>