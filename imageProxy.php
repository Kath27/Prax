<?php
$paciente = $_GET["paciente"];
$admin = $_GET["idAdmin"];
              

require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;

$object_url = 'gs://imagespacientes/paciente' . $paciente . "_" . $admin . ".png";
$options = stream_context_create(array('gs'=>array('acl'=>'public-read')));

if (!file_exists($object_url)){
    $object_url = "gs://imagespacientes/avatar-def.jpg";
}

$my_file = fopen($object_url, 'rb', false, $options);

header("Content-Type: image/png");
header("Content-Length: " . filesize($object_url)); 

fpassthru($my_file);