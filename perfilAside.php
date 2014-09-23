<div class="cont_welcom">
    <h3><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"];?></h3>
    <?php
    $rol = $_SESSION["rol"]; 
        if($rol=="admin"){ ?>
        <p><?php echo "Administrador";?></p>
    <?php } else{ ?>     
        <p><?php echo "Psicológo";?></p>
    <?php } ?>
</div>