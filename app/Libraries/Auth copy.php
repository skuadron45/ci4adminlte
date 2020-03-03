<?php
if (!defined('BASEPATH')) {
	defined('BASEPATH') or exit('No direct script access allowed');
}
/**
 * @property CI_Controller $ci
 * @property M_auth $m_auth
 * 
 * @property CI_Session $session
 * @property CI_Encryption $encryption
 */
class Auth
{
	private $ci;
	private $session;
	private $encryption;
	private $m_auth;
	private $m_module;

	private const SESSION_KEY = "admin";

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->library(['session']);
		$this->session = $this->ci->session;
	}

	public function login($username, $password)
	{

		$this->ci->load->helper('array');

		$this->ci->load->library(['encryption']);
		$this->encryption = $this->ci->encryption;
		$this->ci->load->model('m_auth');
		$this->m_auth = $this->ci->m_auth;
		$this->ci->load->model('m_module');
		$this->m_module = $this->ci->m_module;

		$user = $this->m_auth->validateUser($username);
		if (isset($user)) {
			$userPassword = $user['password'];
			//$passwordDecrypt = $password;
			$passwordDecrypt = $this->encryption->decrypt($userPassword);
			if ($password === $passwordDecrypt) {
				$userGroupId = $user['user_group_id'];

				//Privileges
				$privileges = $this->m_auth->getUserPrivileges($userGroupId);

				//User modules filter by privileges
				$privilegeIds = populateArrayWithKey($privileges, 'module_id');
				$userModules = $this->m_module->getUserModules($privilegeIds);

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
					'user' => $userData,
					'privileges' => $privileges,
					'modules' => $userModules
				];
				$this->session->set_userdata(self::SESSION_KEY, $sessionData);
				return true;
			}
		}
		return false;
	}

	public function getSuccessUrl()
	{
		$this->ci->load->helper('array');
		$privileges = $this->getUserPrivileges();
		$moduleUrls = populateArrayWithKey($privileges, 'module_url');
		$defaultUrl = count($privileges) > 0 ? $moduleUrls[0] : '';
		$homeUrl = $this->getUserData('home_module_url');
		$url = isset($homeUrl) ? in_array($homeUrl, $moduleUrls) : false;
		return $url ? $homeUrl : $defaultUrl;
	}

	public function encrptPassword($password)
	{
		$this->ci->load->library(['encryption']);
		$this->encryption = $this->ci->encryption;
		return $this->encryption->encrypt($password);
	}

	public function getUser()
	{
		$sessionData = $this->session->userdata(self::SESSION_KEY);
		return isset($sessionData['user']) ? $sessionData['user'] : null;
	}

	public function getUserData($key = 'username')
	{
		$userData = $this->getUser();
		return isset($userData[$key]) ? $userData[$key] : null;
	}

	public function getUserModules()
	{
		$sessionData = $this->session->userdata(self::SESSION_KEY);
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
		$sessionData = $this->session->userdata(self::SESSION_KEY);
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

	public function hasLogin()
	{
		$hasLogin = $this->session->userdata(self::SESSION_KEY);
		return $hasLogin;
	}
	public function logout()
	{
		$this->session->unset_userdata(self::SESSION_KEY);
	}
}
