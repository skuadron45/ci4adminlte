<?php

namespace App\Libraries;

class Auth
{

	private const SESSION_KEY = "admin";

	public function __construct()
	{
	}

	public function login($username, $password)
	{

		return false;
	}

	public function getSuccessUrl()
	{
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

	public function hasLogin()
	{
	}
	public function logout()
	{
	}
}
