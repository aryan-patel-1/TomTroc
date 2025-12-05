<?php

$pageTitle = $title ?? 'Tom Troc';

require_once './views/templates/header.php';
echo $content;

require_once './views/templates/footer.php';