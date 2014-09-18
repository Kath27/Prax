<?php
    include('config.php');
    $sql = "SELECT ctagmail_usuario FROM prax.admin_admin, prax.admin_psico";
    $result = mysql_query($sql,$link)or die(exit(mysql_error($link))); 
    echo $result;
?>