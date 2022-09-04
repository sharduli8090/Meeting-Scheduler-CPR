<?php
session_start();
unset($_SESSION['activeuser']);
unset($_SESSION['activeusername']);
header("Location:/");
