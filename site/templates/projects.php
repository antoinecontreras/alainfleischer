<?php

namespace ProcessWire;

$valeur = null;
if (isset($_GET['valeur'])) {
    $valeur = $_GET['valeur']; // Récupère la valeur passée dans l'URL
} else {
    echo "Aucune valeur passée dans l'URL.";
}
$project = $pages->findOne("template=project, title=$valeur");
?>




<div id="content" class="container">

    <div class="projectSmall" id="<?= $project->title; ?>">
        <?php if ($project->img) :
        ?>
            <div class="thumbProject">
                <div>
                    <img class="" draggable="false" src="<?= $project->img->url ?>" />
                </div>
                <div class="cartelProject">
                    <p style="font-size:xx-large;">Title</p>
                    <p><?= $project->date . ' - ' . $project->date_end; ?></p>
                    <p class="infoProject"><?= $project->textarea; ?></p>
                </div>
            </div>
        <?php endif; ?>


        <?php if ($project->gallery) : ?>
            <div class="galleryProject">
                <?php

                foreach ($project->gallery as $image) : ?>
                    <img draggable="false" width="300" src="<?php echo $image->url; ?>" />
                <?php endforeach; ?>

            <?php endif; ?>
            </div>
    </div>
</div>