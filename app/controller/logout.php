<?php
session_start();
session_unset();
session_destroy();
header("Location: ../views/login.php"); // Redirecionar para a página de login após o logout
exit;
?>
