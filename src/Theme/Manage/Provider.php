<?php

namespace Benlumia007\Backdrop\Updater\Theme\Manage;
use Benlumia007\Backdrop\Tools\ServiceProvider;

class Provider extends ServiceProvider {
	public function register() {
		$this->app->singleton( 'backdrop/updater/theme/manage', Component::class );
	}

	public function boot() {
		$this->app->resolve( 'backdrop/updater/theme/manage')->boot();
	}
}
