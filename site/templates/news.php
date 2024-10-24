<?php

namespace ProcessWire;

$news = $pages->find("template=new");
$newsByDate = [];

// Parcours des actualités pour les trier par date
foreach ($news as $new) {
    // Récupération de la date
    $date = $new->date; // Assurez-vous que cela retourne une chaîne de date valide

    // Ajoute la page à la date correspondante dans le tableau
    if (!isset($newsByDate[$date])) {
        $newsByDate[$date] = [];
    }
    $newsByDate[$date][] = $new;
}

uksort($newsByDate, function($a, $b) {
    return strtotime($b) <=> strtotime($a); // Inverser l'ordre ici
});
?>

<div id="content" class="container">
    <div class="page_row collection_nav"></div>
    <div class="page_row collection_tab">
    <?php
    $currentMonthYear = ''; // Variable pour stocker le mois et l'année courants

    // Boucle sur les dates triées
    foreach ($newsByDate as $date => $newsItems) {
        // Créer un objet DateTime pour formater la date
        $dateFromObj = new \DateTime($date);
        $monthYear = $dateFromObj->format('F Y'); // Récupérer le mois et l'année au format 'Month Year'

        // Afficher le mois et l'année
        if ($currentMonthYear !== $monthYear) {
            $currentMonthYear = $monthYear; 
            echo "<h2>$currentMonthYear</h2>"; // Affichez le mois et l'année
        }

        // Afficher les actualités pour cette date
        foreach ($newsItems as $new) {
            $title = $new->title;
            if (!empty($title)) :
                $place = $new->place;
                $dateFrom = $new->date; // Date de début
                $dateTo = $new->date_end; // Date de fin

                // Convertir la date de fin en objet DateTime
                $dateToObj = new \DateTime($dateTo); // Création de l'objet DateTime pour la date de fin

                ?>
                <div>
                    <?php
                    $informations = $new->textarea;
                    $more_description = $new->more_description;
                    $link = $new->link;

                    echo "<p>$title</p>";
                    if (!empty($place)) {
                        echo "<p><strong>Adresse : </strong>$place</p>";
                    }
                    if (!empty($dateFrom)) {
                        echo "<p><strong>Date : </strong>" . $dateFromObj->format('F j, Y') . " " . (!empty($dateTo) ? "- " . $dateToObj->format('F j, Y') : '') . "</p>";
                    }

                    if (!empty($informations)) {
                        echo "<p><strong>Informations : </strong>$informations</p>";
                    }

                    if (!empty($more_description)) {
                        echo "<p><strong>Informations supplémentaires : </strong>$more_description</p>";
                    }
                    if (!empty($link)) {
                        echo "<a draggable='false' target='_blank' href='$link'>$link</a>";
                    }
                    ?>
                </div>
                <?php
            endif; // end of title check
        } // end of newsItems loop
    } // end of newsByDate loop
    ?>
    </div>
</div>
