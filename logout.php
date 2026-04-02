<?php
require __DIR__ . '/vendor/autoload.php';
session_start();
session_unset();
session_destroy();
echo json_encode($_SESSION);
exit;
