<?php
require_once('./includes/admin_redirect.inc.php');
require_once('./includes/connection.inc.php');
require_once('./includes/cluster_utilities.inc.php');

$conn = dbConnect('read');

require_once('./includes/calc_view_all_problems_stats.inc.php');

echo '<div class="loader"></div>';

$title = "Loading | View All Problems";
require_once('./includes/template_begin.inc.php');

require_once('./includes/view_all_problems.inc.php');

require_once('./includes/template_end.inc.php');
?>
