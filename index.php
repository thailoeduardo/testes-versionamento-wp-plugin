<?php
/*
Plugin Name: Testes Versionamento WP Plugin
Author:      Thailo Eduardo
Author URI:  https://github.com/thailoeduardo/
Description: PLUGIN DESCRIPTION
Version:     1.0.3
Text Domain: text-domain
 */

require_once( 'BFIGitHubPluginUploader.php' );

if ( is_admin() ) {
	new BFIGitHubPluginUpdater(__FILE__, 'thailo-eduardo', "testes-github-plugin-updater", "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");
}