<?php

class dataAuth {

	private $options = [
		'restriction_msg' => "vous n'avez pas acces a cette page"
	];
	private $session;

	public function __construct($session, $options = []){
		$this->options = array_merge($this->options, $options);
		$this->session = $session;
	}

	public function hashPassword($password) {
		return password_hash($password, PASSWORD_BCRYPT);
	}

	public function update($db, $username, $lastname, $firstname, $email, $password){
		$user = $this->user();
		if($password != "") {
			$password = $this->hashPassword($password);
			$db->query("UPDATE users SET username = ?, lastname = ?, firstname = ?, email = ?, password = ? WHERE id = $user->id", [ 
				$username, 
				$lastname,
				$firstname,
				$email,
				$password,
			]);
		} else {
			$db->query("UPDATE users SET username = ?, lastname = ?, firstname = ?, email = ? WHERE id = $user->id", [ 
				$username, 
				$lastname,
				$firstname,
				$email,
			]);
		}
		$user = $db->query('SELECT * FROM users WHERE id = ?', [$user->id])->fetch();
		$this->connect($user);
	}

	public function register($db, $username, $lastname, $firstname, $email, $password){
		$password = $this->hashPassword($password);
		$token = Str::random(60);
		$db->query("INSERT INTO users SET username = ?, lastname = ?, firstname = ?, email = ?, password = ?, confirmation_token = ?, access = 1", [ 
			$username, 
			$lastname,
			$firstname,
			$email,
			$password,
			$token
		]);
		$user_id = $db->lastInsertId();
		$to = $email;
		require_once 'vendor/autoload.php';
		if($_SERVER['SERVER_NAME'] == 'localhost'){
			$transport = Swift_SmtpTransport::newInstance('mailtrap.io', 25)
            ->setUsername('your_mail')
            ->setPassword('your_password');
		} else {
			$transport = Swift_MailTransport::newInstance();
		}
		$mailer = Swift_Mailer::newInstance($transport);
		$message = Swift_Message::newInstance('confirmation de compte')
			->setFrom(['loyan.thomas@gmail.com' => 'gmail.com'])
			->setTo(["$to"])
			->setBody("http://localhost/depot/gestion_espace_membre-Refactoring\r\n/confirm.php?id=$user_id\r\n&token=$token");
		$result = $mailer->send($message);
	}

	public function confirm($db, $user_id, $token){
		$user = $db->query("SELECT * FROM users WHERE id = ?", [$user_id])->fetch();
		if($user && $user->confirmation_token == $token) {	
			$db->query("UPDATE users SET confirmation_token = NULL, comfirmed_at = NOW() WHERE id = ?", [$user_id]);
			$this->session->write('auth', $user);
			return true;
		} 
		return false;
	}

	public function restrict(){
		if(!$this->session->read('auth')) {
			$this->session->setFlash('danger', $this->options['restriction_msg']);
			App::redirection('login.php');
			exit();
		}
	}

	public function user() {
		if(!$this->session->read('auth')){
			return false;
		}
		return $this->session->read('auth');
	}

	public function connect($user){
		$this->session->write('auth', $user);
	}

	public function connectFromCookie($db) {
		if(isset($_COOKIE['remember']) && $this->user()) {
			$remember_token = $_COOKIE['remember'];
			$parts = explode('==', $remember_token);
			$user_id = $parts[0];
			$user = $db->query('SELECT * FROM users WHERE id = ?', [$user_id])->fetch();
			if($user){
				$expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'ratonlaveurs');
				if($expected == $remember_token){
					$this->connect($user);
					setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
				} else {
					setcookie('remember', null, -1);
				}
			} else {
				setcookie('remember', null, -1);
			}
		}
	}

	public function login ($db, $username, $password, $remember) {
		$user = $db->query('SELECT * FROM users WHERE (username = :username OR email = :username) AND comfirmed_at IS NOT NULL', ['username' => $username])->fetch();
		if(password_verify($password, $user->password)) {
			$this->connect($user);
			if($remember) {
				$this->remember($db, $user->id);
			}
			return $user;
		} else {
			return false;
		}
	}

	public function remember ($db, $user_id) {
		$remember_token = Str::random(250);
		$db->query('UPDATE users SET remember_token = ? WHERE id = ?', [$remember_token, $user_id]);
		setcookie('remember', $user_id . "==" . $remember_token . sha1($user_id . 'ratonlaveurs'), time() + 60 * 60 * 24 * 7);
	}

	public function logout () {
		$this->session->delete('auth');
		setcookie('remember', null, -1);
	}

	public function resetPassword($db, $email) {
		$user = $db->query('SELECT * FROM users WHERE email = ? AND comfirmed_at IS NOT NULL', [$email])->fetch();
		if($user) {
			$reset_token = Str::random(60);
			$db->query('UPDATE users SET reset_token = ?, reset_at = NOW() WHERE email = ?', [$reset_token, $user->email]);
			require_once 'vendor/autoload.php';
			if($_SERVER['SERVER_NAME'] == 'localhost'){
				$transport = Swift_SmtpTransport::newInstance('mailtrap.io', 25)
                ->setUsername('your_mail')
                ->setPassword('your_password');
			} else {
				$transport = Swift_MailTransport::newInstance();
			}
			$to = $email;
			$mailer = Swift_Mailer::newInstance($transport);
			$message = Swift_Message::newInstance('Reinitialisation de mot de passe')
				->setFrom(['loyan.thomas@gmail.com' => 'gmail.com'])
				->setTo(["$to"])
				->setBody("http://localhost/depot/gestion_espace_membre-Refactoring\r\n/reset.php?id={$user->id}\r\n&reset_token=$reset_token");
				$result = $mailer->send($message);
			return $user;
		} 
		return false;
	}

	public function checkReset($db, $user_id, $token) {
		return $db->query('SELECT * FROM users WHERE id = ? AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)', [$user_id, $token])->fetch();
	}
}