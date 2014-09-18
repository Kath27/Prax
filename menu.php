<?php
    session_start();
    $rol = $_SESSION["rol"];
?>
<ul>
    <?php if ($rol == "admin"){ ?>
        <a href="list-paci"><li class="active">Lista de Psicólogo </li></a>
    <?php } ?>
    
    <?php if ($rol=="psico"){ ?>
    <a href="list-user"><li class="active">Lista de Pacientes </li></a>
    <?php } ?>
    
    <?php if ($rol == "admin"){ ?>
    <a href="indexAdminPsico.php"><li>Agregar Psicólogo </li></a>
    <?php } ?>
    
    <?php if ($rol == "psico"){ ?>
    <a href="indexPaciente.php"><li>Agregar Paciente </li></a>
    <?php } ?>
    
    <?php if ($rol == "admin"){ ?>
    <a href="#"><li>Reportes </li></a>
    <?php } ?>
</ul>