<?php namespace ProcessWire;
$projects = $pages->find("template=project");
$projectsByCategory = [];
foreach ($projects as $project) {
bd($project);
}
?>

<div id="content" class="container">
projet
</div>