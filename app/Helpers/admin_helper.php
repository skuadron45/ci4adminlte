<?php
function get_admin_base($url = "")
{
	return 'admin/' . $url;
}

function get_admin_view($url = "")
{
	return get_admin_base($url);
}

function populateDsDropdown($records, $valueField, $labelField)
{
	$dsDropdown = [];
	foreach ($records as $record) {
		$value = isset($record[$valueField]) ? $record[$valueField] : null;
		$label = false;
		if (is_callable($labelField)) {
			$label = $labelField($record);
		} else {
			$label = isset($record[$labelField]) ? $record[$labelField] : null;
		}
		if (isset($value) && isset($label)) {
			$dsDropdown[$value] = $label;
		}
	}
	return $dsDropdown;
}

function admin_site_url($url = "")
{
	return site_url(get_admin_base($url));
}

function print_admin_site_url($url = "")
{
	echo admin_site_url($url);
}

function redirect_admin($url = "")
{
	if (isset($url)) {
		redirect(get_admin_base($url));
	}
}
