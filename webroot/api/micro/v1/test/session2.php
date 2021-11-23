<?php

session_start();
header('Set-Cookie: ' . session_name() . '=' . session_id() . '; SameSite=None; Secure');
echo '<pre>';
print_r($_SESSION);
 ?>