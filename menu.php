<?php
    @session_start();
    $rol = $_SESSION["rol"];
    $url = $_SERVER['REQUEST_URI'];
?>
<ul>
    <?php if ($rol == "admin"){
        $class=(stristr($url, "list-user"))?'class="active"':"";
         ?>
        <a href="list-user"><li <?php echo $class;?>>Psicologos </li></a>
    <?php } ?>
    
    <?php if ($rol=="psico" || $rol == "admin"){ 
        $class=(stristr($url, "list-paci"))?'class="active"':"";
        ?>
    <a href="list-paci"><li <?php echo $class;?>>Pacientes </li></a>
    <?php } ?>
    
    <?php if ($rol == "admin"){ 
        $class=(stristr($url, "list-admin"))?'class="active"':"";
        ?>
    <a href="list-admin"><li <?php echo $class;?>>Administradores </li></a>
    <?php } ?>
    
    <?php if ($rol == "admin"){
        $class=(stristr($url, "AdminAdmin"))?'class="active"':"";
         ?>
    <a href="AdminAdmin"><li <?php echo $class;?>>Crear administrador</li></a>
    <?php } ?>
    
    <?php if ($rol == "admin"){ 
        $class=(stristr($url, "AdminPsico"))?'class="active"':"";
        ?>
    <a href="AdminPsico"><li <?php echo $class;?>>Crear psicologo </li></a>
    <?php } ?>
    
    
    <?php if ($rol == "psico" || $rol == "admin"){
        $class=(stristr($url, "indexPaciente"))?'class="active"':"";
         ?>
    <a href="indexPaciente"><li <?php echo $class;?>>Crear paciente </li></a>
    <?php } ?>
    
    <?php if ($rol == "psico"){
        $class=(stristr($url, "edicionPsico"))?'class="active"':"";
         ?>
    <a href="edicionPsico"><li <?php echo $class;?>>Editar perfil</li></a>
    <?php } ?>
    
    <?php if ($rol == "psico" || $rol == "admin"){ ?>
    <a target="_blank" href="https://docs.google.com/a/prax.com.co/forms/d/1wV0tEynr9ban2s7-D0jOM_ES6t6B16qvku360ywn6iE/viewform"><li>Sugerencias </li></a>
    <?php } ?>
    
    <?php if ($rol == "admin"){ 
        $class=(stristr($url, "reportes"))?'class="active"':"";
        ?>
    <a href="#"><li>Reportes </li <?php echo $class;?>></a>
    <?php } ?>
</ul>