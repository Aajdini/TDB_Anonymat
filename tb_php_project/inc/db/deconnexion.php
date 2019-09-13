<?php
session_start();
unset($_SESSION["sess_user_id"]);
unset($_SESSION["sess_username"]);
header("Location:../../index.php");