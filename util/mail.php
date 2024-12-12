<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

    class Mailer {
        public function sendMail($name,$recipientMail,$password){
                    
        $Ownemail='layanlordneuman@gmail.com';
        $Ownname='City Taxi';

        $mail = new PHPMailer(true);

            //Server settings
            $mail->isSMTP();                              
            $mail->Host       = 'smtp.gmail.com';      
            $mail->SMTPAuth   = true;            
            $mail->Username   = 'layanlordneuman@gmail.com';   
            $mail->Password   = 'uvbrmcgdleebwtfk';    
            $mail->SMTPSecure = 'ssl';           
            $mail->Port       = 465;                                    

            //Recipients
            $mail->setFrom( $Ownemail, $Ownname); 
            $mail->addAddress($recipientMail);    
            $mail->addReplyTo($Ownemail, $Ownname); 

            //Content
            $mail->isHTML(true);               
            $mail->Subject = 'City Taxi Registetion';   

        $mail->Body ='
        <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    body {font-family: Arial, sans-serif;background-color: #f6f6f6;margin: 0;padding: 0;color: #333333;
                    }.container {max-width: 600px;margin: 0 auto;background-color: #ffffff;padding: 20px;border-radius: 8px;
                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                    }.header {text-align: center;padding: 20px;background-color: #3498db;color: #ffffff;border-radius: 8px 8px 0 0;
                    }.content {padding: 20px;line-height: 1.6;}.content h2 {color: #3498db;}.content h3{color: #3498db;}
                    .content .Bold{color: #757a75;}.content p {margin-bottom: 20px;}
                    .button {display: block;width: 200px;margin: 20px auto;padding: 10px;text-align: center;background-color: #3498db;
                    color: #ffffff;text-decoration: none;border-radius: 4px;
                    }.footer {text-align: center;padding: 10px;font-size: 12px;color: #777777;border-top: 1px solid #dddddd;}
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>City Taxi Registration</h1>
                    </div>
                    <div class="content">
                        <h2>Hello ' . htmlspecialchars($name) . ',</h2>
                        <p>Thank you for registering with City Taxi! We are excited to have you onboard.</p>
                        <h3>User Name:<span class="Bold">'.htmlspecialchars($recipientMail).'</span></h3>
                        <h3>Password :<span class="Bold">'.htmlspecialchars($password).'</span></h3>
                        <a href="#" class="button" style="text-decoration: none;color: #ffffff;">Login</a>
                        <p>Best regards, <br> City Taxi Team</p>
                    </div>
                    <div class="footer">
                        <p>&copy; ' . date("Y") . ' City Taxi. All rights reserved.</p>
                        <p>This is an automated message, please do not reply.</p>
                    </div>
                </div>
            </body>
            </html>';

            $mail->send();
                }
            }
?>
<?php
?>
