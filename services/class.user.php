<?php

require_once 'dbconfig.php';

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}
	
	public function register($uname,$email,$upass,$code)
	{
		try
		{							
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode) 
			                                             VALUES(:user_name, :user_mail, :user_pass, :active_code)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	public function login($email,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			
			if($stmt->rowCount() == 1)
			{
				if($userRow['userStatus']=="Y")
				{
					if($userRow['userPass']==md5($upass))
					{
						$_SESSION['userSession'] = $userRow['userID'];
					    $msg = array('userID'=>$userRow['userID'], 'email_address'=>$userRow['userEmail'], 'first_name'=>$userRow['first_name'], 'last_name'=>$userRow['last_name']);
					    echo json_encode($msg);						
						return true;
					}
					else
					{
						//header("Location: index.php?error");
						$msg = array('account'=>'Incorrect Password', 'response'=>'failure');
						echo json_encode($msg);
						exit;
					}
				}
				else
				{
					//header("Location: index.php?inactive");
					$msg = array('account'=>'No Y Value set', 'response'=>'failure');
					echo json_encode($msg);
					exit;
				}	
			}
			else
			{
				$msg = array('account'=>'No account found', 'response'=>'failure');
						echo json_encode($msg);
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}
	
	
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		//header("Location: $url");
	}
	
	public function logout()
	{
		session_destroy();
		$_SESSION['userSession'] = false;
	}
	
	function send_mail($email,$message,$subject)
	{						
		require_once('mailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		$mail->SMTPDebug  = 0;                     
		$mail->SMTPAuth   = true;                                 
		$mail->Host       = "mail.annotate.tech";      
		$mail->Port       = 25;             
		$mail->AddAddress($email);
		$mail->Username="auto-confirm@annotate.tech";  
		$mail->Password="XtcVsAA1979";            
		$mail->SetFrom('auto-confirm@annotate.tech','Annotate team');
		$mail->AddReplyTo("support@annotate.tech","Annotate Support");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}	
}