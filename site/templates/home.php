<?php

namespace ProcessWire;


// ------------------------------------------------------
// The #content div in this file will replace the #content div in _main.php
// when the Markup Regions feature is enabled, as it is by default. 
// You can also append to (or prepend to) the #content div, and much more. 
// See the Markup Regions documentation:
// https://processwire.com/docs/front-end/output/markup-regions/
$projects = $pages->find("template=project");
$projectsByCategory = [];
foreach ($projects as $project) {

	$categoryTitle = $project->filter->title;
	if (!isset($projectsByCategory[$categoryTitle])) {
		$projectsByCategory[$categoryTitle] = [];
	}
	$projectsByCategory[$categoryTitle][] = $project;
}
?>
<div id="content" class="container">
	<div class="page_row collection_nav">
		<?php foreach ($projectsByCategory as $categoryTitle => $projects) : ?>
			<?php foreach ($projects as $project) : ?>
				<div class="nav_item" id="<?= $project->title; ?>">
					<?php if ($project->img) : ?>
						<div class="nav_wallpaper">
							<img class="" draggable="false" src="<?php echo $project->img->url; ?>" />
						</div>
					<?php endif; ?>
					<h2 class="nav_cartel"><?= $project->textarea; ?></h2>
					<p><?= $project->date . ' - ' . $project->date_end; ?></p>
					<?php if ($project->gallery) : ?>
						<div class="nav_gallery">
							<?php foreach ($project->gallery as $gallery) : ?>
								<img draggable="false" width="300" src="<?php echo $gallery->url; ?>" />
							<?php endforeach; ?>
						<?php endif; ?>
						</div>
				</div>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</div>




	<div class="page_row collection_tab">
		<div class="collection_filter">
			<?php
			$counter = 0;

			foreach ($projectsByCategory as $categoryTitle => $projects) :
				$filters = [];
				foreach ($projects as $project) :
					$filterTitle = $project->filter->title;

					if (!isset($filters[$filterTitle])) :
						$filters[$filterTitle] = $filterTitle; ?>
						<a draggable="false" href="#<?= $filterTitle; ?>" class="filter-link" onclick="highlightLink('<?= $filterTitle; ?>')"><?= $filterTitle ?></a>
			<?php endif;
				endforeach;
			endforeach; ?>
		</div>

		<!-- Section des projets -->
		<?php foreach ($projectsByCategory as $categoryTitle => $projects) : ?>
			<div id="<?= $categoryTitle; ?>" class="collection_category">
				<?php
				$projectsByYear = [];
				foreach ($projects as $project) :
					$year = date('Y', strtotime($project->date));
					$projectsByYear[$year][] = $project;
				endforeach;
				foreach ($projectsByYear as $year => $projects) :
					echo "<p class='collection_year'>{$year}</p>";
					foreach ($projects as $project) : ?>
						<a id="<?= $project->title; ?>" draggable="false" class="collection_item <?= $project->img ? 'with_img' : ''; ?>">
							<?php if ($project->img) : ?>
								<img draggable="false" src="<?php echo $project->img->url; ?>" />
							<?php endif; ?>
							<p><?= $project->title; ?></p>
						</a>
				<?php endforeach;
				endforeach;
				?>
			</div> <!-- Fin de la catégorie -->
		<?php endforeach; ?>
	</div>


</div>