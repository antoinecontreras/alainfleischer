<?php

namespace ProcessWire;

// This is defined by $config->appendTemplateFile in /site/config.php, and
// Optional main output file, called after rendering page’s template file. 
// is typically used to define and output markup common among most pages.
// 	
// When the Markup Regions feature is used, template files can prepend, append,
// replace or delete any element defined here that has an "id" attribute. 
// https://processwire.com/docs/front-end/output/markup-regions/

/** @var Page $page */
/** @var Pages $pages */
/** @var Config $config */

$home = $pages->get('/');
/** @var HomePage $home */

$urlMenu = [];
$urlMenu[] = ['url' => $pages->findOne("name=home")->url, 'title' => 'Collection'];
$urlMenu[] = ['url' => $pages->findOne("name=fond_de_dotation")->url, 'title' => 'Fond de Dotation'];
$urlMenu[] = ['url' => $pages->findOne("name=bio")->url, 'title' => 'Biographie'];
$urlMenu[] = ['url' => $pages->findOne("name=news")->url, 'title' => 'News'];
$hslColor = $home->color;
list($h, $s, $l) = sscanf($hslColor, 'hsl(%d, %d%%, %d%%)');
$dynamicLight = "hsl($h, 64%, 93%)";
$backMenu = $page->template->name == "projects";
$backLink = null;
$activeSession = false;
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
// session_unset(); // Vide toutes les variables de session

if (!$session->get('visited')) {
	if ($page->template->name !== 'home') {
		echo $config->httpHost;
			$session->redirect("/");
	
	}else{
		$session->set('visited', true);
	}
} else {
	
	
	
	$activeSession = true;
}


if ($backMenu) {
	if (isset($_GET['filter'])) {
		$valeur = $_GET['filter']; // Récupère la valeur du filtre
		$backLink = $pages->findOne("template=home")->url . "#" . $valeur;
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head id="html-head">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $page->title; ?></title>
	<link rel="stylesheet" href="<?= $config->urls->templates ?>font/Selecta-Regular.woff" as="font" type="font/woff" crossorigin>
	<link rel="stylesheet" type="text/css" href="<?php echo $config->urls->templates; ?>styles/main.css" />

	<script src="<?php echo $config->urls->templates; ?>scripts/main.js"></script>
</head>
<style>
	@font-face {
		font-family: 'Selecta-Regular';
		src: url('<?= $config->urls->templates ?>font/Selecta-Regular.woff2') format('woff2');
		font-weight: normal;
		font-style: normal;
	}

	.menu {
		background: <?= $home->color; ?>;
	}

	.intro.menu {
		background: black;
		height: 100dvh;
	}

	@keyframes introMenu {
		from {
			height: 100dvh;
			background: black;
		}

		to {
			height: 4rem;
			background: <?= $home->color; ?>;
		}
	}

	@keyframes introMenuBefore {
		from {
			height: 100dvh;
			background: black;
		}

		to {
			height: 7rem;
			background: <?= $home->color; ?>;
		}
	}

	@media only screen and (max-width: 1300px) {
		#topnav:not(.intro)::before {
			background: <?= $home->color; ?>;
		}

		.intro#topnav::before {
			animation: introMenuSmallBefore 1.6s cubic-bezier(0.89, 0.17, 0.45, 1) 2s;
			animation-fill-mode: forwards;
		}

		@keyframes introMenuSmallBefore {
			from {
				height: 100dvh;
				/* background: black; */
			}

			to {
				height: 4rem;
				background: <?= $home->color; ?>;
			}
		}

	}

	.intro.menu {
		animation: introMenuSmall 1.6s cubic-bezier(0.89, 0.17, 0.45, 1) 2s;
		animation-fill-mode: forwards;
	}

	@keyframes introMenuSmall {
		from {
			height: 100dvh;
			background: black;
		}

		to {
			height: 3rem;
			background: <?= $home->color; ?>;
		}
	}


	@media (hover: none) {
		.intro#topnav::before {
			animation: introOffColor 1.6s cubic-bezier(0.89, 0.17, 0.45, 1) 2s;
			animation-fill-mode: forwards;
		}

		@keyframes introOffColor {
			from {
				height: 100dvh;
				background: black;
			}

			to {
				height: 7rem;
				background: <?= $home->color; ?>;
			}
		}

	}









	body {
		font-family: 'Selecta-Regular', sans-serif;
	}
</style>

<body id="html-body" data-page-type="<?= $page->template ?>">
	<!-- style="background:<?php $home->color; ?>"  -->
	<div class="menu  <?= $activeSession ? '' : 'intro' ?>" id="topnav">
		<a draggable='false' href='<?= $backLink ?>' class='menu_back <?= ($backMenu) ? 'active' : '' ?>'>
			<img src="<?= $config->urls->templates ?>picto/back.svg" alt="" />
		</a>
		<input type="checkbox" id="menuToggle" class="menu_toggle">

		<label for="menuToggle" class="menu_burger">
			<!-- Icone du burger -->
			<span></span>
			<span></span>
			<span></span>
		</label>
		<div class="menu_items">
			<?php foreach ($urlMenu as $item) {
				$activeClass = ($item['url'] == $page->url) ? 'active' : '';
				echo "<a draggable='false' href='{$item['url']}' class='{$activeClass}'>{$item['title']}</a> ";
			} ?>
			<div>
				<a class="contact_mobile" draggable="false" href="mailto:<?php echo $home->email; ?>">Contact</a>
			</div>
		</div>
		<div draggable='false' class="menu_logo">
			<div class="logo">Alain</div>
			<div class="logo">fleischer</div>
			<!-- <img draggable="false" src="<? $config->urls->templates ?>/picto/alain.svg"  /> -->
			<!-- <img draggable="false" src="<? $config->urls->templates ?>/picto/fleischer.svg"  /> -->
		</div>
		<a class="contact" draggable="false" href="mailto:<?php echo $home->email; ?>">Contact</a>
	</div>


	<h1 id="headline">
		<?php if ($page->parents->count()): // breadcrumbs 
		?>

		<?php endif; ?>
		<?php $page->title; // headline 
		?>
	</h1>

	<div id="content">
		Default content
	</div>

	<?php if ($page->hasChildren): ?>
		<ul>
			<?php $page->children->each("<li><a href='{url}'>{title}</a></li>"); // subnav 
			?>
		</ul>
	<?php endif; ?>

	<?php if ($page->editable()): ?>

	<?php endif; ?>

</body>

</html>