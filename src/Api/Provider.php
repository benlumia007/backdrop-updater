<?php

namespace Benlumia007\Backdrop\Updater\Api;
use Benlumia007\Backdrop\Tools\ServiceProvider;

class Provider extends ServiceProvider {
	public function register() {
		$this->app->singleton( 'backdrop/updater/api', Component::class );
	}

	public function boot() {
		$this->app->resolve( 'backdrop/updater/api')->boot();
	}
}
