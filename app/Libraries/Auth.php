<?php

namespace App\Libraries;

use Config\Services;
use Config\Encryption;
use App\Models\MAuth;
use APP\Models\MHelper;

class Auth
{

	private const SESSION_KEY = "admin";

	/**
	 * @var \CodeIgniter\Session\Session
	 */
	private $session = null;

	public function __construct()
	{
		$this->session = Services::session();
	}

	public function hasLogin()
	{
		$hasLogin = $this->session->get(self::SESSION_KEY);
		return $hasLogin;
	}

	public function login($username, $password)
	{

		$mAuth = new MAuth();
		$user = $mAuth->validateUser($username);
		if (isset($user)) {
			$userPassword = $user['password'];
			$passwordDecrypt = $password;

			$config         = new Encryption();
			$config->key    = hex2bin('e3464c731115cf50ab1b29de0ff4c3ce');

			$encrypter = Services::encrypter($config);

			try {
				$passwordDecrypt = $encrypter->decrypt(base64_decode($userPassword));
				if ($password === $passwordDecrypt) {

					$userData = array(
						'id' => $user['id'],
						'username' => $user['username'],
						'fullname' => $user['fullname'],
						'email' => $user['email'],
						'user_group_id' => $user['user_group_id'],
						'home_module_url' => $user['home_module_url'],
						'type' => $user['type'],
					);

					//Privileges
					$privileges = [];

					//User modules filter by privileges
					$privilegeIds = [];
					$userModules = [];

					$sessionData = [
						'hasLogin' => true,
						'user' => $userData,
						'privileges' => $privileges,
						'modules' => $userModules
					];
					$this->session->set(self::SESSION_KEY, $sessionData);
					return true;
				}
			} catch (\Throwable $th) {
				return false;
			}
		}
		return false;
	}
	public function logout()
	{
		$this->session->remove(self::SESSION_KEY);
	}

	public function getSuccessUrl()
	{
		helper('admin');
		return get_admin_base('dashboard');
	}

	public function encrptPassword($password)
	{
	}

	public function getUser()
	{
	}

	public function getUserData($key = 'username')
	{
	}

	public function getUserModules()
	{
	}

	public function hasPrivilege($moduleId)
	{
	}

	public function hasAddPrivilege($moduleId)
	{
	}

	public function hasEditPrivilege($moduleId)
	{
	}

	public function hasDeletePrivilege($moduleId)
	{
	}

	public function hasAddOrEditPrivileges($moduleId)
	{
	}

	private function getCrudPrivilege($moduleId, $key)
	{
	}

	public function getUserPrivileges()
	{
	}

	public function getUserPrivilegeIds()
	{
	}
}
