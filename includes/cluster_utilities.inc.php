<?php
require_once('connection.inc.php');

function getClusterName ($clusterID){
	$conn = dbConnect("read");
	$sql = "SELECT cluster FROM cluster WHERE cluster_id = ?";
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->bind_param('d', $clusterID);
	$stmt->bind_result($cluster);
	$stmt->execute();
	$stmt->store_result();
	$stmt->fetch();
	return $cluster;
}