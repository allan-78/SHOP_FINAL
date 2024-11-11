<?php
require_once '../includes/functions/functions.php';

session_start();
session_destroy();

header("Location: index.php");
exit;
?>