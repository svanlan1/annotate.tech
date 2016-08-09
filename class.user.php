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
	
	public function register($uname,$email,$upass,$fname,$lname,$code)
	{
		try
		{							
			$password = md5($upass);
			$date = time();
			//$date = date('m,d,y');     // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
			$stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,first_name,last_name,userPass,tokenCode,created) 
			                                             VALUES(:user_name, :user_mail, :first_name, :last_name, :user_pass, :active_code, :created)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":first_name",$fname);
			$stmt->bindparam(":last_name",$lname);
			$stmt->bindparam(":user_pass",$password);
			$stmt->bindparam(":active_code",$code);
			$stmt->bindparam(":created",$date);
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
						return true;
					}
					else
					{
						header("Location: index.php?error");
						exit;
					}
				}
				else
				{
					header("Location: index.php?inactive");
					exit;
				}	
			}
			else
			{
				header("Location: index.php?error");
				exit;
			}		
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

	public function update($email,$upass,$fName,$lName,$userID)
	{
		try
		{	
			mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
			mysql_select_db("annotate_main");
			mysql_query("UPDATE tbl_users SET userEmail = '$email', first_name = '$fName', last_name = '$lName' WHERE userID = '$userID'");
			

			return true;
		}
		catch(PDOException $ex)
		{
			echo 'The statement didnt execute';
		}
		
	}

	public function add_recommendation($userID,$quickname,$example,$description,$additional,$rec_id)
	{
		try
		{
			$stmt = $this->conn->prepare("INSERT INTO recs(userID,quickname,example,description,additional,rec_id) 
			                                             VALUES(:user_id, :qn, :ex, :descr, :add, :rec_id)");
			$stmt->bindparam(":user_id",$userID);
			$stmt->bindparam(":qn",$quickname);
			$stmt->bindparam(":ex",$example);
			$stmt->bindparam(":descr",$description);
			$stmt->bindparam(":add",$additional);
			$stmt->bindparam(":rec_id",$rec_id);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			//echo $ex;
			//header('Location:recs.php?error');
			echo $ex;
		}
	}

	public function update_rec($quickname,$example,$description,$additional,$rec_id)
	{
		try
		{
			$stmt = $this->conn->prepare("UPDATE recs SET quickname=:qn,example=:ex,description=:descr,additional=:add WHERE rec_id='$rec_id'");
			$stmt->bindparam(":qn",$quickname);
			$stmt->bindparam(":ex",$example);
			$stmt->bindparam(":descr",$description);
			$stmt->bindparam(":add",$additional);
			$stmt->execute();	
			return $stmt;
		} 
		catch(PDOException $ex)
		{
			echo $ex;
		}
	}

	public function delete_rec($rec_id)
	{
		try
		{
			$stmt = $this->conn->prepare("DELETE FROM recs WHERE rec_id='$rec_id'");
			$stmt->execute();	
			return $stmt;
		} 
		catch(PDOException $ex)
		{
			echo $ex;
		}
	}	

	public function add_annotation($userID,$url,$obj) 
	{
		try
		{	
			$date = time();

			$stmt = $this->conn->prepare("INSERT INTO store(userID,url,obj,updated) 
			                                             VALUES(:user_id, :url, :obj, :updated)");
			$stmt->bindparam(":user_id",$userID);
			$stmt->bindparam(":url",$url);
			$stmt->bindparam(":obj",$obj);
			$stmt->bindparam(":updated",$date);
			$stmt->execute();	
			return $stmt;

			/*INSERT INTO 'annotate_main'.'store' ('userID', 'url', 'updated', 'group_id', 'session_id') VALUES ('1', 'http://sva11y.com', '121215154665', '25', '12345');*/
			echo 'SUCCESS';
			//return true;
		}
		catch(PDOException $ex)
		{
			echo $ex;
		}
	}

	public function update_annotation($userID,$url,$obj)
	{
		try
		{	

			echo $url, "\r\n";
			echo $session_id, "\r\n";
			$date = time();
			mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
			mysql_select_db("annotate_main");
			//mysql_query("UPDATE store SET obj = '$obj', updated = '$date' WHERE userID = '$userID'");

			mysql_query("INSERT INTO news (userID, url, obj, updated) 
										VALUES ('$userID', '$url','$obj','$date')
											ON DUPLICATE KEY UPDATE
												userID='$userID', url='$url', obj='$obj', updated='$date'");		

			return true;
		}
		catch(PDOException $ex)
		{
			echo $ex;
		}			
	}

	public function delete_annotation($session_id)
	{
		try
		{
			$stmt = $this->conn->prepare("DELETE FROM results WHERE session_id='$session_id'");
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex;
		}
	}

	public function add_news($by,$date,$id,$story,$title,$fName,$lName)
	{
		try {
			$date = time();
			mysql_connect ("localhost", "annotate_admin", "XtcVsAA1979");
			mysql_select_db("annotate_main");
			mysql_query("INSERT INTO news (created_by, date_updated, story_id, title, story, created_first_name, created_last_name) 
										VALUES ('$by', '$date','$id','$title','$story', '$fName', '$lName')");		

			return true;
		}
		catch (PDOException $ex)
		{
			echo $ex;
		}
	}
	
	
	public function is_logged_in()
	{
		if(isset($_SESSION['userSession']))
		{
			return true;
		}
	}

	public function is_admin($row)
	{
		if($row['admin'] === 'Y')
		{
			return true;
		} else {
			echo 'Not admin';
		}
	}	
	
	public function redirect($url)
	{
		header("Location: $url");
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
		//header("Location: home.php");
		//header('Location: success.php');
	}		
}