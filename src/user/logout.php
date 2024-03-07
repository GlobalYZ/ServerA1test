<?php
// logout.php
session_start();
session_unset();
session_destroy();

ob_start(); // Start output buffering
header("Location: /index.php?message=" . urlencode("logout successful"));
ob_end_flush(); // Send output buffer and turn off output buffering
