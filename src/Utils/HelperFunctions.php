<?php
namespace App\Utils;
require __DIR__ . '/../../vendor/autoload.php';

use App\Utils\MyRequest;


class HelperFunctions{

    static  function loginCheck(){
        
        //check accesstoken
        if(!isset($_SESSION["user"]) || !isset($_SESSION["refreshToken"])){
            HelperFunctions::logout();
        }
        $token = HelperFunctions::getNewAccessToken();
        
        if(!$token){
            HelperFunctions::logout();
        }
        $_SESSION["accessToken"] = $token;
        
    }
    static function logout(){
        
        session_start();
        session_destroy();
        header('Location: ../index.php');
        exit;
    }


    
  static  function cookiesCheck(){
        //PopUp für Cookies
        
            if(!isset($_COOKIE['cookies'])){
            // First time visitor
                
                $show_consent = True;	
                $_SESSION["cookieCheck"] = $show_consent;
            }else{
                // We'll get the user preferences
                $show_consent = False; // Don't show the popup	
                $_SESSION["cookieCheck"] = $show_consent;
                $cookies = json_decode($_COOKIE['cookies'],True);
            }
            //check if button submit
        if(isset($_POST['akzeptieren'])){
            $submitbutton= $_POST['akzeptieren'];
            if ($submitbutton){
                //cookies set
                $cookies = ['consent'=>0,'options' => 0];
                $cookies_string = json_encode($cookies);
                setcookie("cookies",$cookies_string,time() + (5256000));
            }
        }    
    }
        

  static function doLogin($email, $password)
    {   // url for server request  --> authentication and token generation
        $req = new MyRequest();         //MyRequest($_SESSION[accessToken])
        try{
           
            $response = $req->request('POST', 'iam/auth/login', [], [
                'email' => $email,
                'password' => $password,
            ]);

            return $response;
        }catch(\Exception $e){            
            Helperfunctions::errorCode($e);
            exit;
        }
    }

 static  function getNewAccessToken(): ?string{
        $req = new MyRequest();

        try{
            $response = $req->request('POST', 'iam/auth/refresh-access-token', [], [
                "token" => $_SESSION["refreshToken"]
            ]);
            
            if(isset($response["accessToken"])){
                return $response["accessToken"]; 
            }
            return null;
        }catch(\Exception $e){
            HelperFunctions::logout();
            exit;
        }
    }

    function getUsers(){
        // normal in session gespeichert
        $token = login("info3@fb-dev.de", "testtest");
        $req = new MyRequest($token);
        $response = $req->request('GET', 'iam/user', [], []);
    }

    static function setActive()
    {   // url for server request  --> authentication with accessToken
        $active = $_POST["active"]; 
        $id = $_POST["id"];
        
         
        $req = new MyRequest($_SESSION["accessToken"]); //MyRequest($_SESSION[accessToken])
       
        try{
            $response = $req->request('PATCH', 'iam/user/'.$id, [], [
                "active" => $active
            ]);

            return $response;
        }catch(\Exception $e){
            var_dump($e->getMessage());
            exit;
        }
    }

    static function deleteUser()
    {   // url for server request  --> authentication with accessToken
        $id = $_POST["userId"];
        var_dump($id);
        
        
        $req = new MyRequest($_SESSION["accessToken"]); //MyRequest($_SESSION[accessToken])
       
        try{
            $response = $req->request('DELETE', 'iam/user/'.$id, [], [
                
            ]);

            return $response;
        }catch(\Exception $e){
            
            echo("Access Denied");
            header("Location: home.php");
            exit;
        }
    }

    static function errorCode($resp){
        //condition if array_key_exists in the object $resp
    //check if Error-Messege is send
    if (str_contains($resp,'code')) {    
        //check if Error-Messege is replied and show Website based on Error-Code and stop script
        if (str_contains($resp,'"code":401') || str_contains($resp,'"code":404')){
            // return error 
            die('
            <!DOCTYPE html>
            <html>            
            <head>
                <title>Login</title>            
            </head> 
            <body>
                <div class="container"></div>
                    <h1>Login</h1>
                    <span>Login failed, wrong Username or Password</span>
                    <br><br>
                    <form action="../index.php">
                        <button type="submit">zurück zum Login</button>
                      </form>
                </div>
            </body>            
            </html>
            ');
        }else if(str_contains($resp,'"code":403')){
            die('
            <!DOCTYPE html>
            <html>            
            <head>
                <title>Login</title>            
            </head>            
            <body>
                <div class="container"></div>
                    <h1>Login</h1>
                    <span>Login erfolgreich</span>
                    <br><br>
                    <span>Dieser Account wurde noch nicht aktiviert. <br>
                    Die Aktivierung kann einige Zeit dauern. <br>
                    Sollte die Aktivierung nach 24h noch nicht erfolgt sein <br>
                    wenden Sie sich bitte an den Support.
                    </span>
                    <br><br>
                    <form action="../index.php">
                        <button type="submit">zurück zum Login</button>
                      </form>
                </div>
            </body>            
            </html>
            ');
            }
        }else{
            $resp = $resp->getMessage();
            $errorCode=substr($resp, 15, 43);
            die('
            <!DOCTYPE html>
            <html>            
            <head>
                <title>Login</title>            
            </head>            
            <body>
                <div class="container"></div>
                    <h1>Error: 408<h1>
                    '.$errorCode.'
                    <br><br>
                    <form action="../index.php">
                        <button type="submit">zurück zum Login</button>
                      </form>
                </div>
            </body>            
            </html>
            ');
        }
    }

    static function pwdResetUser(){
         // url for server request  --> authentication with accessToken
         $password = $_POST["passwordResetUser"]; 
         $id = $_SESSION["user"]["id"];
         var_dump($_SESSION["user"]["id"]);
         $req = new MyRequest($_SESSION["accessToken"]); //MyRequest($_SESSION[accessToken])
        
         try{
             $response = $req->request('PATCH', 'iam/user/'.$id, [], [
                 "password" => $password
             ]);
 
             return $response;
         }catch(\Exception $e){
             var_dump($e->getMessage());
             exit;
         }
    }

    static function pwdResetAdmin(){
        // url for server request  --> authentication with accessToken
        $password = $_POST["passwordResetAdmin"]; 
        $id = $_POST["userIds"];
        
        $req = new MyRequest($_SESSION["accessToken"]); //MyRequest($_SESSION[accessToken])
       
        try{
            $response = $req->request('PATCH', 'iam/user/'.$id, [], [
                "password" => $password
            ]);

            return $response;
        }catch(\Exception $e){
            var_dump($e->getMessage());
            die("Error: Permission denied");
            exit;
        }
   }


   //Mails über SMTP-Server
function mail_att($to,$subject,$message,$anhang)
{
$absender = "Mein Name";
$absender_mail = "ich@domain";
$reply = "antwort@adresse";

$mime_boundary = "-----=" . md5(uniqid(mt_rand(), 1));

$header  ="From:".$absender."<".$absender_mail.">\n";
$header .= "Reply-To: ".$reply."\n";

$header.= "MIME-Version: 1.0\r\n";
$header.= "Content-Type: multipart/mixed;\r\n";
$header.= " boundary=\"".$mime_boundary."\"\r\n";

$content = "This is a multi-part message in MIME format.\r\n\r\n";
$content.= "--".$mime_boundary."\r\n";
$content.= "Content-Type: text/html charset=\"iso-8859-1\"\r\n";
$content.= "Content-Transfer-Encoding: 8bit\r\n\r\n";
$content.= $message."\r\n";

//$anhang ist ein Mehrdimensionals Array
//$anhang enthält mehrere Dateien
if(is_array($anhang) AND is_array(current($anhang)))
   {
   foreach($anhang AS $dat)
      {
      $data = chunk_split(base64_encode($dat['data']));
      $content.= "--".$mime_boundary."\r\n";
      $content.= "Content-Disposition: attachment;\r\n";
      $content.= "\tfilename=\"".$dat['name']."\";\r\n";
      $content.= "Content-Length: .".$dat['size'].";\r\n";
      $content.= "Content-Type: ".$dat['type']."; name=\"".$dat['name']."\"\r\n";
      $content.= "Content-Transfer-Encoding: base64\r\n\r\n";
      $content.= $data."\r\n";
      }
   $content .= "--".$mime_boundary."--"; 
   }
else //Nur 1 Datei als Anhang
   {
   $data = chunk_split(base64_encode($anhang['data']));
   $content.= "--".$mime_boundary."\r\n";
   $content.= "Content-Disposition: attachment;\r\n";
   $content.= "\tfilename=\"".$anhang['name']."\";\r\n";
   $content.= "Content-Length: .".$data['size'].";\r\n";
   $content.= "Content-Type: ".$anhang['type']."; name=\"".$anhang['name']."\"\r\n";
   $content.= "Content-Transfer-Encoding: base64\r\n\r\n";
   $content.= $data."\r\n";
   } 
   
 


if(@mail($to, $subject, $content, $header)) return true;
else return false;
}
    //end
}
?>