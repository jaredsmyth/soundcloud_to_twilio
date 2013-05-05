<?php
// jared smith | http://jaredsmyth.info
//

// make sure to install the twilio php library
require('twilio-twilio-php-c1ad9c4/Services/Twilio.php');

$root_server = '___ENTER_YOUR_ROOT_SEVER_PATH_HERE___';

$twilNumber = '___YOUR_TWILIO_PHONE_NUMBER___';

$account = "___YOUR_TWILIO_ACCOUNT___";
$token = "___YOUR_TWILIO_TOKEN___";
$client = new Services_Twilio($account, $token);


if ( isset( $_REQUEST ) && !empty( $_REQUEST ) ) {
  if (
    isset( $_REQUEST['phoneNumber'], $_REQUEST['soundcloudUrl'] ) &&
      !empty( $_REQUEST['phoneNumber'] )  
    ) {
      $url = $_REQUEST['soundcloudUrl'];
      $to = $_REQUEST['phoneNumber'];
      $message = $_REQUEST['message'];
      
      //create xml with random id, so that we can remove the file
      //when the call disconnects
      $id = rand(17, 124435234);
      $root = simplexml_load_string('<Response><Say voice="woman" language="en-gb">foo</Say><Redirect method="GET"></Redirect></Response>');
      $root->Say = $message;
      // resolve our soundcloud stream url with our python script
      $root->Redirect=exec("python sc.py $url");
      $root->asXml($root_server . '/xmls/file-'.$id.'.xml');
      //make call
      $call = $client->account->calls->create(
        $twilNumber,
        $to,
        '___YOUR_WEB_DOMAIN(EG.http://myapp.com)___/xmls/file-'.$id.'.xml',
        array(
          'Method' => 'GET',
          'StatusCallback' => '___YOUR_WEB_DOMAIN(EG.http://myapp.com)___/callback.php?id='.$id
        )
      );
      print 'Your sound was sent! Thanks!';
    } else {
      print 'ERROR: Not all information was submitted.';
    }
  }
?>

<!DOCTYPE html>
<head>
  <title>soundagram - send a sound</title>
  
  <!-- include bootstrap if you like, but it's not essential -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
    <style type="text/css">
    body{background:#f9f9f9;}
    .wrap {width:50%; margin: 20px auto;}
    header {text-align:center;}
    .btn{float:right;}
    ul {list-style: none; width:400px; margin: 40px auto;}
    textarea, input {width:386px;}
    textarea {height: 150px;}
    input {cursor: pointer; float:right;}
    input#fb-login {margin-right:40px; margin-top:-3px;}
    .topmenu {width: 100%; background: #767676; padding: 10px; height:20px;}
    </style>
</head>
<body>
<div class="wrap">
  <header>
    <h1>soundagram</h1>
    <h2>call a phone. play a soundcloud sound.</h2>
  </header>
  
    <div id="container">
    <form action="" method="post">
     <ul>
        <input type="text" name="name" id="name" placeholder="name" style="visibility:hidden;" /></li>
      <li>
       <label for="phoneNumber">Phone Number</label>
       <input type="text" name="phoneNumber" id="phoneNumber" placeholder="4159671453" /></li>
      <li>
       <label for="soundcloudUrl">soundcloud URL</label>
       <input type="url" name="soundcloudUrl" id="soundcloudUrl" placeholder="http://soundcloud.com/jared-smyth/nine-acres"></input>
      </li>
      <li>
       <label for="message">message to say</label>
       <textarea name="message" id="message" placeholder="hello! i hope you're having a great day! here's a song i think you'll like."></textarea>
      </li>
     <li><input type="submit" name="sendMessage" id="sendMessage" value="Send Sound" /></li>
    </ul>
   </form>
  </div>


</div>
</body>
