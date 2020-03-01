<?php

namespace App\Libraries;

class Adminlte
{
	private $auth;

	private $baseView = 'default';

	private $renderDebug = true;

	protected $vars = array(
		'appName' => 'CP OSHOP',
		'pageTitle' => 'Page Title',
		'contentTitle' => 'Content Title',
		'authFullname' => null,
		'contentView' => null,
		'actionUrl' => '#',
		'backWardUrl' => '#',
		'viewScripts' => [],
		'sidebar' => array(
			'modules' => '',
		)

	);

	public function __construct()
	{
		$this->auth = new Auth();

		//Default vars
		$this->vars['authFullname'] = $this->auth->getUserData('fullname');				
	}

	public function crudForm($mainActionUrl = '#', $backWardUrl = '#', $useRefererFirst = true)
	{
		$actionUrl = admin_site_url($mainActionUrl);
		$backWardUrl = admin_site_url($backWardUrl);

		$this->setActionUrl($actionUrl);
		$this->setBackwardUrl($backWardUrl);
	}

	private function setActionUrl($url)
	{
		$this->vars['actionUrl'] = $url;
		$this->vars['actionUrlJson'] = json_encode($url, JSON_UNESCAPED_SLASHES);
	}

	private function setBackwardUrl($backwardUrl, $useRefererFirst = true)
	{
		$url = $backwardUrl;
		if ($useRefererFirst) {
			// $referer = $this->ci->input->server('HTTP_REFERER');
			// $url = isset($referer) ? $referer : $url;
		}
		$this->vars['backWardUrl'] = $url;
		$this->vars['backWardUrlJson'] = json_encode($url, JSON_UNESCAPED_SLASHES);
	}

	public function setPageTitle($pageTitle)
	{
		$this->vars['pageTitle'] = $pageTitle;
	}

	public function setContentTitle($contentTitle)
	{
		$this->vars['contentTitle'] = $contentTitle;
	}

	public function selectModule($selectedModule)
	{
		$userPrivileges = $this->auth->getUserPrivileges();
		$selectedModulePath = $selectedModule;

		foreach ($userPrivileges as $userPrivilege) {
			$module_id = $userPrivilege['module_id'];
			$module_name = $userPrivilege['module_name'];

			if ($module_id == $selectedModule) {
				$selectedModulePath = $userPrivilege['module_id_path'];
				$this->setPageTitle($module_name);
				break;
			}
		}

		$userModule = $this->auth->getUserModules();

		$sideBar = $this->sidebarModules($userModule, null, $selectedModulePath);
		$this->vars['sidebar']['modules'] = $sideBar;

		$this->vars['selectedModule'] = $selectedModule;
		$this->vars['selectedModulePath'] = $selectedModulePath;
	}

	public function addViewScript($viewScript = null)
	{
		$this->vars['viewScripts'][] = get_admin_view($viewScript);
	}

	public function setContentView($contentView = null)
	{
		$this->vars['contentView'] = get_admin_view($contentView);
	}

	public function renderDebug($debug = true)
	{
		$this->renderDebug = $debug;
	}

	public function setVars($vars = array())
	{
		$this->vars = array_merge($this->vars, $vars);
	}

	public function renderContentView($contentView = null)
	{
		if (isset($contentView)) {
			$this->baseView = get_admin_view($contentView);
		}

		if ($this->renderDebug) {
			$this->vars['debugs']['vars'] = $this->vars;
		}

		echo view(get_admin_view($this->baseView), $this->vars);
	}

	private function sidebarModules($modules, $parent_id = NULL, $selected_module_path = "4")
	{
		$sideBar = '';

		foreach ($modules as $module) {
			$module_item = $module['item'];
			$module_name = $module_item['module_name'];
			$module_id = $module_item['id'];
			$module_url = $module_item['module_url'];
			$module_icon = $module_item['module_icon'];
			$parent_module_id = $module_item['parent_module_id'];

			$selected_module_paths = explode(',', $selected_module_path);
			$isActive = false;

			$isActive = in_array($module_id, $selected_module_paths);

			$isActiveClass = $isActive ? 'active' : '';

			$childOpen = $isActive ? 'menu-open' : '';

			$moduleSiteUrl = site_url("$module_url");

			$childs = $module['children'];
			$childCount = count($childs);
			$hasChildren = $childCount > 0;

			$hasChildrenItemLiClass = $hasChildren ? 'has-treeview' : '';
			$hasChildrenItemtoggle = $hasChildren ? '<i class="right fas fa-angle-left"></i>' : '';

			$moduleLabel = $module_name;

			if (ENVIRONMENT != 'production') {
				$moduleLabel = $module_id . "-" . $module_name;
			}

			$sideBar .= "<li class='nav-item $hasChildrenItemLiClass $childOpen'>";
			$sideBar .= "<a id='' href='$moduleSiteUrl' class='nav-link $isActiveClass'>";
			$sideBar .= "<i class='$module_icon nav-icon'></i>";
			$sideBar .= "<p>&nbsp; $moduleLabel $hasChildrenItemtoggle </p>";
			$sideBar .= "</a>";
			if ($hasChildren) {
				$sideBar .= "<ul class='nav nav-treeview'>";
			}
			$sideBar .= $this->sidebarModules($childs, $parent_module_id, $selected_module_path);
			if ($hasChildren) {
				$sideBar .= "</ul>";
			}
			$sideBar .= "</li>";
		}

		return $sideBar;
	}

	public function showLoginPage()
	{
	}

	public function validationLogin($ci)
	{
	}
}
