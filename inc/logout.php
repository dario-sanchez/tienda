<?php
require_once 'bootstrap.php';
ob_start();
session_start();
http_response_code(500);
session_destroy();
http_response_code(200);
echo json_encode(true);
ob_end_flush();