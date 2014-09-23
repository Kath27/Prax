<?php
    @session_start();
    $rol = $_SESSION["rol"];
    $url = $_SERVER['REQUEST_URI'];
?>
<ul>
    <?php if ($rol == "admin"){
        $class=(stristr($url, "list-user"))?'class="active"':"";
         ?>
        <a href="list-user"><li <?php echo $class;?>>Lista de Psicólogo </li></a>
    <?php } ?>
    
    <?php if ($rol=="psico" || $rol == "admin"){ 
        $class=(stristr($url, "list-paci"))?'class="active"':"";
        ?>
    <a href="list-paci"><li <?php echo $class;?>>Lista de Pacientes </li></a>
    <?php } ?>
    
    <?php if ($rol == "admin"){ 
        $class=(stristr($url, "AdminPsico"))?'class="active"':"";
        ?>
    <a href="AdminPsico"><li <?php echo $class;?>>Agregar Psicólogo </li></a>
    <?php } ?>
    
    <?php if ($rol == "psico" || $rol == "admin"){
        $class=(stristr($url, "indexPaciente"))?'class="active"':"";
         ?>
    <a href="indexPaciente"><li <?php echo $class;?>>Agregar Paciente </li></a>
    <?php } ?>
    
    <?php if ($rol == "psico"){
        $class=(stristr($url, "edicionPsico"))?'class="active"':"";
         ?>
    <a href="edicionPsico"><li <?php echo $class;?>>Editar perfil</li></a>
    <?php } ?>
    
    <?php if ($rol == "admin"){ 
        $class=(stristr($url, "reportes"))?'class="active"':"";
        ?>
    <a href="#"><li>Reportes </li <?php echo $class;?>></a>
    <?php } ?>
</ul>