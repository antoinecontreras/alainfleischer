<?php

namespace ProcessWire;

$news = $pages->find("template=new");


foreach ($news as $new) :
    $title = $new->title;
    if (!empty($title)) : ?>

<div id="content" class="container">

        <div>
            <?php $place = $new->place;
            $name_collab = $new->name_collab;
            $date = $new->date;
            $informations = $new->textarea;
            $date_end = $new->date_end;
            $more_description = $new->more_description;
            $link = $new->link;

            echo "<p><strong>Titre : </strong>$title</p>";
            if (!empty($place)) {
                echo "<p><strong>Adresse : </strong>$place</p>";
            }
            if (!empty($name_collab)) {
                echo "<p><strong>Collaborations : </strong>$name_collab</p>";
            }
            if (!empty($date)) {
                echo "<p><strong>Date de début : </strong>$date</p>";
            }
            if (!empty($informations)) {
                echo "<p><strong>Informations : </strong>$informations</p>";
            }
            if (!empty($date_end)) {
                echo "<p><strong>Date de fin : </strong>$date_end</p>";
            }
            if (!empty($more_description)) {
                echo "<p><strong>Informations supplémentaires : </strong>$more_description</p>";
            }
            if (!empty($link)) {
                echo "<a href='$link'>$link</a>";
            }
            ?>
        <?php endif; ?>
        </div>
    <?php endforeach; ?>



    </div>