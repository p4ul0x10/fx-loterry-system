<?php
	
	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';   

    ini_set( 'display_errors', 1);
    error_reporting( E_ALL );

   	$system_name = $_SERVER['SERVER_NAME'];
    
    if($subject == "created_acc"){
    
    	$body = 'Welcome '.$fname.' '.$lname.', account as been created.<br>Login: '.$email.'<br>Password: '.$senha.'<br>For more info learn <a href="http://'.$system_name.'/terms.php" title="terms">terms</a> and <a href="http://'.$system_name.'/faq.php" title="faq">faq</a> questions.<a href="http://fxrobot.free.nf/" title="FXROBOT"><br><img src="http://fxrobot.free.nf/images/logofx2.png" alt="investefx" class="float-left logo" style="margin-top: 10px;" width="150px" height="35px"></a><br>Admin team.';
    	$subject_e = "Created account";

    }else if($subject == "deposit"){
    
    	$value = $valor;

    	$get_user = mysqli_query($con, "SELECT id FROM usuarios WHERE email = '$email'");

    	while ($row_user  = mysqli_fetch_array($get_user)) {
    		$id_user = $row_user['id'];	
    	}

    	$get_dep = mysqli_query($con, "SELECT id FROM deposits WHERE id_user = '$id_user' ORDER BY id DESC LIMIT 1");
    	while ($row_dep = mysqli_fetch_array($get_dep)) {
    		$id_dep = $row_dep['id'];
    	}

    	$body = 'Hi <b>'.$nome.'</b>,<br>deposit request '.$id_dep.' created worth '.$value.'waiting payment.<br> <a href="http://fxrobot.free.nf/" title="FXROBOT"><img src="http://fxrobot.free.nf/images/logofx2.png" alt="investefx" class="float-left logo" style="margin-top: 10px;" width="150px" height="35px"></a><br>Admin team.';

    	$subject_e = "Deposit open";
    
    }else if($subject == "deposit_confirmed"){
    	
    	$body = "";
    	$subject_e = "";
    
    }else if($subject == "2fafx"){
    
    	$body = "";
    	$subject_e = "";
    
    }else if($subject == "withdraw"){
    
    	$body = 'Hi '.$nome.', you requested a withdrawal.<br>Withdrawal referring to the deposit of '.$coin_with.', id <b>'.$id_dep.'</b> carried out successfully.<br>Status: waiting for confirmation<br>Wallet: '.$wallet.'.<br><a href="http://fxrobot.free.nf/" title="FXROBOT"><img src="http://fxrobot.free.nf/images/logofx2.png" alt="investefx" class="float-left logo" style="margin-top: 10px;" width="150px" height="35px"></a><br>Admin team.';

    	$subject_e = "Withdraw realized";
    
    }else if($subject == "newpw"){
    
    	$body = "";
    	$subject_e = "";
    
    }else if($subject == "deposit accepted"){

        $body = 'Hi '.$nome.', you send a confirmation.<br>Deposit <b>'.$id_charnum.'</b>, confirmed in the amount of '.$value." ".$coin_name.'.<br>payment proof: '.$tx.', wait for daily rewards.<br><a href="http://fxrobot.free.nf/" title="FXROBOT"><img src="http://fxrobot.free.nf/images/logofx2.png" alt="investefx" class="float-left logo" style="margin-top: 10px;" width="150px" height="35px"></a><br>Admin team.';
      
        $subject_e = "Deposit confirmed";
    
    }else if($subject == "deposit ticket accepted"){

        $body = 'Hi '.$nome.', you send a confirmation.<br>Deposit <b>'.$orig_id_charnum.'</b>, confirmed in the amount of '.$value." ".$coin_name.'.<br>payment proof: '.$tx.', wait for daily rewards.<br><a href="http://fxrobot.free.nf/" title="FXROBOT"><img src="http://fxrobot.free.nf/images/logofx2.png" alt="investefx" class="float-left logo" style="margin-top: 10px;" width="150px" height="35px"></a><br>Admin team.';
      
        $subject_e = "Deposit confirmed";
    }
 	
    // Instância da classe
    $mail = new PHPMailer(true);
   try
    {
        // Configurações do servidor
        $mail->isSMTP();        //Devine o uso de SMTP no envio
        $mail->SMTPAuth = true; //Habilita a autenticação SMTP
        $mail->Username   = "undercrazyal@gmail.com";
        $mail->Password   = "njoe trod demo bpmt";
        // Criptografia do envio SSL também é aceito
        $mail->SMTPSecure = 'TLS';
        // Informações específicadas pelo Google
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        // Define o remetente
        $mail->setFrom('undercrazyal@gmail.com', 'FXROBOT');
        // Define o destinatário
        $mail->addAddress($email, 'Destinatário');
        //$mail->SMTPOptions = array( 'ssl' => array( 'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true ) );

        // Conteúdo da mensagem
        $mail->isHTML(true);  // Seta o formato do e-mail para aceitar conteúdo HTML
        $mail->CharSet = 'UTF-8'; 
        $mail->Subject = $subject_e;
        $mail->Body    = $body;
        
        // Enviar
        $mail->send();
        //echo 'A mensagem foi enviada!';
    }
    catch (Exception $e)
    {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

?>