<?php
/**
 * Logout Handler
 */

require_once '../config/Auth.php';

Auth::logout();
header('Location: login.php');
exit;
