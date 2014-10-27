<div id="profile_welcom_header_tootip">
    <div class="cont_avatar">
        <div class="avatar">
            <img src="<?php echo $_SESSION["img"];?>"/>
        </div>
    </div>
    <div class="cont_welcom">
        <h3 id="perfilNombre"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"];?></h3>
        <p id="perfilGmail"><?php echo $_SESSION["ctagmail_usuario"];?></p>
    </div> 
</div>
<button type="button" id="logut" onclick="javascript:location.href='logOut'">Salir de la Plataforma</button>