# Backdrop
Backdrop is a framework for developing ClassicPress and WordPress Themes.

The main objective of this Backdrop Core is build a theme with its finest tools that you can use.

## Requirements
- WordPress 4.9 or higher (Compatible with ClassicPress)
- PHP 5.6 or higher ( PHP 7.0 or higher is recommended )
- Composer

## Documentations
The documentations is under construction and will be available when I finished writing up everything I need.

## Installation
Since Backdrop uses composer, we will use composer to install the framework inside of the directory you are working with.

<pre>
composer require benlumia007/backdrop
</pre>

The next step is to add the autload to your functions.php within your working directory.

<pre>
if ( file_exists( get_parent_theme_file_path( 'vendor/autoload.php' ) ) ) {
	require_once( get_parent_theme_file_path( 'vendor/autoload.php' ) );
}
</pre>