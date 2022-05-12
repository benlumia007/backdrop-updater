<?php

namespace Benlumia007\Backdrop\Updater\Theme\Type;
use Benlumia007\Backdrop\Tools\ServiceProvider;

class Provider extends ServiceProvider {
	public function register() {
		$this->app->singleton( 'backdrop/updater/type/theme', Component::class );
	}

	public function boot() {
		$this->app->resolve( 'backdrop/updater/type/theme')->boot();
	}
}
