<?php

namespace Benlumia007\Backdrop\Updater\Settings;
use Benlumia007\Backdrop\Tools\ServiceProvider;

class Provider extends ServiceProvider {
	public function register() {
		$this->app->singleton( 'backdrop/updater/settings', Component::class );
	}

	public function boot() {
		$this->app->resolve( 'backdrop/updater/settings')->boot();
	}
}
