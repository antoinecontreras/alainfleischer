<?php namespace ProcessWire;

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
	
$home = $pages->get('/'); /** @var HomePage $home */

$urlMenu = [];
$urlMenu[] = ['url' => $pages->findOne("name=home")->url, 'title' => 'Collection'];
$urlMenu[] = ['url' => $pages->findOne("name=fond_de_dotation")->url, 'title' => 'Fond de Dotation'];
$urlMenu[] = ['url' => $pages->findOne("name=bio")->url, 'title' => 'Biographie'];
$urlMenu[] = ['url' => $pages->findOne("name=news")->url, 'title' => 'News'];



?><!DOCTYPE html>
<html lang="en">
	<head id="html-head">
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo $page->title; ?></title>
		<link rel="stylesheet" href="<?= $config->urls->templates ?>font/Selecta-Regular.woff2" as="font" type="font/woff2" crossorigin>

		<link rel="stylesheet" type="text/css" href="<?php echo $config->urls->templates; ?>styles/main.css" />
		<script src="<?php echo $config->urls->templates; ?>scripts/main.js"></script>
	</head>
	<body id="html-body" data-page-type="<?= $page->template ?>" >

		<div class="menu" id="topnav" style="background:<?= $home->color; ?>">
			<div class="menu_items"> <?php foreach ($urlMenu as $item) {
    				echo "<a draggable='false' href='{$item['url']}'>{$item['title']}</a> ";
				}?>
			</div>
			 <a draggable="false" href="mailto:<?php echo $home->email; ?>">Contact</a>
			</div>

		
		<h1 id="headline">
			<?php if($page->parents->count()): // breadcrumbs ?>
				
			<?php endif; ?>
			<?php  $page->title; // headline ?>
		</h1>
		
		<div id="content">
			Default content
		</div>
	
		<?php if($page->hasChildren): ?>
		<ul> 
			<?php  $page->children->each("<li><a href='{url}'>{title}</a></li>"); // subnav ?>
		</ul>	
		<?php endif; ?>
		
		<?php if($page->editable()): ?>
		
		<?php endif; ?>
	
	</body>
</html>