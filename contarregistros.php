<?php
    include ("config.php");
    include ("utilidades.php");
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
</head>
<body>
    <?php
        $sql = "SELECT COUNT(*) FROM prax.admin_psico";
        $result = mysql_query($sql, $link) or die(imprimir_respuesta(false,mysql_error($link),"ErrorMysql"));
        $result = mysql_fetch_row($result)[0];
        mysql_close($link);
        echo "Número de registros: " . $result;            
    ?>
    
</body>
</html>
