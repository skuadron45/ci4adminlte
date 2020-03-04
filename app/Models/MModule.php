<?php

namespace App\Models;

use \Config\Database;

class MModule
{

	public function getConfigurableModuleList()
	{
		$moduleIds = $this->getConfigurableModuleIds();
		return $this->getUserModuleList($moduleIds);
	}

	private function getConfigurableModuleIds()
	{
		$db = Database::connect();
		$builder = $db->table('v_modules');
		$builder->select("group_concat(DISTINCT id) AS ids", false);
		$builder->where('show_on_privilege', 1);
		$query = $builder->get();
		$row = $query->getRowArray();
		$modulesIdsString = $row['ids'];
		$modulesIds = [''];
		if (isset($modulesIdsString)) {
			$modulesIds = explode(',', $modulesIdsString);
		}
		return $modulesIds;
	}

	public function getUserModuleList(array $privilegeModuleIds)
	{
		//$parentIds = $this->getParentModuleIds($privilegeModuleIds);
		//if (isset($parentIds)) {
		//$parentIds = explode(',', $parentIds);
		//$privilegeModuleIds = array_merge($privilegeModuleIds, $parentIds);
		//}
		$db = Database::connect();
		$builder = $db->table('v_modules');
		$builder->whereIn('id', $privilegeModuleIds);
		$query = $builder->get();
		$modules = $query->getResultArray();
		return $modules;
	}

	public function getAllModules()
	{
		$moduleIds = $this->getAllModuleIds();
		return $this->getUserModules($moduleIds);
	}

	private function getAllModuleIds()
	{
		$db = Database::connect();
		$builder = $db->table('v_modules');
		$builder->select("group_concat(DISTINCT id) AS ids", false);
		$query = $builder->get();
		$row = $query->getResultArray();
		$modulesIdsString = $row['ids'];
		$modulesIds = [''];
		if (isset($modulesIdsString)) {
			$modulesIds = explode(',', $modulesIdsString);
		}
		return $modulesIds;
	}

	public function getUserModules(array $privilegeModuleIds)
	{
		/**
		 * Bila module dalam $privileges adalah child, parent auto include.
		 */
		$parentIds = $this->getParentModuleIds($privilegeModuleIds);
		if (isset($parentIds)) {
			$parentIds = explode(',', $parentIds);
			$privilegeModuleIds = array_merge($privilegeModuleIds, $parentIds);
		}

		$modules = $this->getUserModuleByParent(null, $privilegeModuleIds);
		return $modules;
	}

	private function getUserModuleByParent($parent_id, array $privilegeModuleIds)
	{
		$db = Database::connect();
		$builder = $db->table('v_modules');
		$builder->where('parent_module_id', $parent_id);
		$builder->whereIn('id', $privilegeModuleIds);
		$query = $builder->get();
		$rows = $query->getResultArray();

		$modules = [];
		foreach ($rows as $row) {
			$parent_id = $row['id'];
			$childs = $this->getUserModuleByParent($parent_id, $privilegeModuleIds);
			$modules[] = array(
				'item' => $row,
				'children' => count($childs) > 0 ? $childs : []
			);
		}
		return $modules;
	}

	private function getParentModuleIds(array $privilegeIds)
	{
		$db = Database::connect();
		$builder = $db->table('v_modules');
		$builder->select("group_concat(DISTINCT parent_module_id) AS parent_ids", false);
		$builder->whereIn('id', $privilegeIds);
		$builder->where('parent_module_id is not null', '', false);
		$query = $builder->get();
		$row = $query->getRowArray();
		$parentIds = $row['parent_ids'];
		return $parentIds;
	}
}
