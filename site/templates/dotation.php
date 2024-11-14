<?php

namespace ProcessWire;

$dotation = $pages->findOne("template=dotation");
$fields = [];




?>
<div id="content" class="container home">
	<div class="page_row collection_nav">
		<div class="nav_wallpaper">
			<?php if ($dotation->img): ?>
				<img class="" draggable="false" src="<?= $dotation->img->url ?>" />
			<?php endif; ?>
		</div>
	</div>
	<div class="page_row collection_tab dotation">
		<div class="dotation_text">
			<p><?= $dotation->text ?></p>
			<div><?= html_entity_decode($dotation->textarea) ?></div>
		</div>

		<div class="dotation_members">
			<div class="dotation_fields">
				<p class="dotation_title">Team</p>
			</div>
			<div class="dotation_repeater">
					<?php foreach ($dotation->list_3columns as $content) : ?>
						<div>
							<?php bd($content->title) ?>
							<p><?= $content->title?></p>
							<p><?= $content->text ?></p>
							<p><?= $content->more_text ?></p>
						</div>
					<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>
</div>