<?php
    use google\appengine\api\app_identity\AppIdentityService;
    use \google\appengine\api\mail\Message;
    
    try
    {
      $access_token = AppIdentityService::getAccessToken('https://www.googleapis.com/auth/userinfo.email');
      $headers= array(sprintf('Authorization: OAuth %s', $access_token['access_token']));
      $opts = array(
          'http' => array(
            'header' => implode("\r\n", $headers),
          ),
        );
        
      $message = new Message();
      $message->setSender("juan.arroyave@qtagtech.com");
      $message->addTo("catalina.meneses@qtagtech.com");
      $message->setSubject("Prax Assist");
      $message->setTextBody("Hello, world!");
      //$message->addAttachment('image.jpg', 'image data', $image_content_id);
      $message->send();
    } catch (InvalidArgumentException $e) {
      echo "Error: ".$e->getMessage();
    }
?>