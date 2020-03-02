<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'AdminNotLogin' => \App\Filters\AdminNotLogin::class,
		'AdminHasLogin' => \App\Filters\AdminHasLogin::class
	];

	public $filters = [
		'AdminNotLogin' => [
			'before' => ['admin/*'],
			'after' => []
		],
		'AdminHasLogin' => [
			'before' => [
				 '/login',
			],
			'after' => []
		],
		'csrf' => [
			'before' => [],
			'after' => []
		]
	];

	public $globals = [
		'before' => [],
		'after'  => [
			'toolbar',
		],
	];

	public $methods = [
		'post' => []
	];
}
