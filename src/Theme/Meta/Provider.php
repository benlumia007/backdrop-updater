<?php

namespace Benlumia007\Backdrop\Updater\Theme\Meta;
use Benlumia007\Backdrop\Tools\ServiceProvider;

class Provider extends ServiceProvider {
	public function register() {
		$this->app->singleton( 'backdrop/updater/theme/meta', Component::class );
	}

	public function boot() {
		$this->app->resolve( 'backdrop/updater/theme/meta')->boot();
	}
}
