<?php

namespace App\Libraries;

use Config\Services;
use App\Models\MAuth;
use App\Models\MModule;

class Auth
{

	private const SESSION_KEY = "admin";

	private const USER_DATA_KEY = "user";

	/**
	 * @var \CodeIgniter\Session\Session
	 */
	private $session = null;

	public function __construct()
	{
		$this->session = Services::session();
		helper('general');
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
			$encrypter = Services::encrypter();
			try {
				$passwordDecrypt = $encrypter->decrypt(base64_decode($userPassword));
				if ($password === $passwordDecrypt) {
					$userGroupId = $user['user_group_id'];

					//Privileges
					$privileges = $mAuth->getUserPrivileges($userGroupId);

					//User modules filter by privileges
					$privilegeIds = populateArrayWithKey($privileges, 'module_id');

					$mModule = new MModule();
					$userModules = $mModule->getUserModules($privilegeIds);

					$userData = array(
						'id' => $user['id'],
						'username' => $user['username'],
						'fullname' => $user['fullname'],
						'email' => $user['email'],
						'user_group_id' => $user['user_group_id'],
						'home_module_url' => $user['home_module_url'],
						'type' => $user['type'],
					);

					$sessionData = [
						'hasLogin' => true,
						self::USER_DATA_KEY => $userData,
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
		$privileges = $this->getUserPrivileges();
		$moduleUrls = populateArrayWithKey($privileges, 'module_url');
		$defaultUrl = count($privileges) > 0 ? $moduleUrls[0] : '';
		$homeUrl = $this->getUserData('home_module_url');
		$url = isset($homeUrl) ? in_array($homeUrl, $moduleUrls) : false;
		return $url ? $homeUrl : $defaultUrl;
	}

	public function encrptPassword($password)
	{
		$encrypter = Services::encrypter();
		return base64_encode($encrypter->encrypt($password));
	}

	public function getUser()
	{
		$sessionData = $this->session->get(self::SESSION_KEY);
		return isset($sessionData[self::USER_DATA_KEY]) ? $sessionData[self::USER_DATA_KEY] : null;
	}

	public function getUserData($key = 'username')
	{
		$userData = $this->getUser();
		return isset($userData[$key]) ? $userData[$key] : null;
	}

	public function getUserModules()
	{
		$sessionData = $this->session->get(self::SESSION_KEY);
		$modules = isset($sessionData['modules']) ? $sessionData['modules'] : [];
		return $modules;
	}

	public function hasPrivilege($moduleId)
	{
		$privileges = $this->getUserPrivileges();
		$privilege = isset($privileges[$moduleId]) ? $privileges[$moduleId] : NULL;
		return $privilege;
	}

	public function hasAddPrivilege($moduleId)
	{
		return $this->getCrudPrivilege($moduleId, 'can_add');
	}

	public function hasEditPrivilege($moduleId)
	{
		return $this->getCrudPrivilege($moduleId, 'can_edit');
	}

	public function hasDeletePrivilege($moduleId)
	{
		return $this->getCrudPrivilege($moduleId, 'can_delete');
	}

	public function hasAddOrEditPrivileges($moduleId)
	{
		return ($this->hasAddPrivilege($moduleId) || $this->hasEditPrivilege($moduleId));
	}

	private function getCrudPrivilege($moduleId, $key)
	{
		$privilege = $this->hasPrivilege($moduleId);
		$isAllow = false;
		if (isset($privilege)) {
			$isAllow = isset($privilege[$key]) ? (bool) $privilege[$key] : false;
		}
		return $isAllow;
	}

	public function getUserPrivileges()
	{
		$sessionData = $this->session->get(self::SESSION_KEY);
		$privileges = isset($sessionData['privileges']) ? $sessionData['privileges'] : [];
		return $privileges;
	}

	public function getUserPrivilegeIds()
	{
		$priviliges = $this->getUserPrivileges();
		$privilegeIds = [];
		foreach ($priviliges as $privilige) {
			$privilegeIds[] = $privilige['module_id'];
		}
		return $privilegeIds;
	}
}
