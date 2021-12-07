<?php
/*
Plugin Name: Testes Versionamento WP Plugin
Author:      Thailo Eduardo
Author URI:  https://github.com/thailoeduardo/
Description: PLUGIN DESCRIPTION
Version:     1.0.0
Text Domain: text-domain
 */

// $chave = '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';
$chave = '';

if ((string) $chave !== '') {
	include_once plugin_dir_path(__FILE__) . 'GHPDUpdater.php';

	$updater = new GHPDUpdater(__FILE__);
	$updater->set_username('thailoeduardo');
	$updater->set_repository('testes-versionamento-wp-plugin');
	$updater->authorize($chave);
	$updater->initialize();

	// echo '<pre>';
	// print_r($$updater);
	// print_r($updater->set_username('thailo-eduardo'));
	// print_r($updater->set_repository('testes-github-plugin-updater'));
	// print_r($updater->authorize($chave));
	// print_r($updater->initialize());
	// echo '</pre>';

}

//https: //code.tutsplus.com/tutorials/distributing-your-plugins-in-github-with-automatic-updates--wp-34817
// https: //getbutterfly.com/how-to-update-your-wordpress-plugin-from-github/
// https: //ralphjsmit.com/github-updater-mechanism/
// require_once 'BFIGitHubPluginUploader.php';

// echo 'teste';

// if (is_admin()) {
// 	new BFIGitHubPluginUpdater(__FILE__, 'thailo-eduardo', "testes-github-plugin-updater", "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");
// }

// class BFIGitHubPluginUpdater {

// 	private $slug; // plugin slug
// 	private $pluginData; // plugin data
// 	private $username; // GitHub username
// 	private $repo; // GitHub repo name
// 	private $pluginFile; // __FILE__ of our plugin
// 	private $githubAPIResult; // holds data from GitHub
// 	private $accessToken; // GitHub private repo token

// 	function __construct($pluginFile, $gitHubUsername, $gitHubProjectName, $accessToken = '') {
// 		add_filter("pre_set_site_transient_update_plugins", array($this, "setTransitent"));
// 		add_filter("plugins_api", array($this, "setPluginInfo"), 10, 3);
// 		add_filter("upgrader_post_install", array($this, "postInstall"), 10, 3);

// 		$this->pluginFile  = $pluginFile;
// 		$this->username    = $gitHubUsername;
// 		$this->repo        = $gitHubProjectName;
// 		$this->accessToken = $accessToken;
// 	}

// 	// Get information regarding our plugin from WordPress
// 	private function initPluginData() {
// 		// code here
// 		$this->slug       = plugin_basename($this->pluginFile);
// 		$this->pluginData = get_plugin_data($this->pluginFile);
// 	}

// 	// Get information regarding our plugin from GitHub
// 	private function getRepoReleaseInfo() {
// 		// code here
// 		// Only do this once
// 		if (!empty($this->githubAPIResult)) {
// 			return;
// 		}

// 		// Query the GitHub API
// 		$url = "https://api.github.com/repos/{$this->username}/{$this->repo}/releases";

// // We need the access token for private repos
// 		if (!empty($this->accessToken)) {
// 			$url = add_query_arg(array("access_token" => $this->accessToken), $url);
// 		}

// // Get the results
// 		$this->githubAPIResult = wp_remote_retrieve_body(wp_remote_get($url));
// 		if (!empty($this->githubAPIResult)) {
// 			$this->githubAPIResult = @json_decode($this->githubAPIResult);
// 		}

// 		// Use only the latest release
// 		if (is_array($this->githubAPIResult)) {
// 			$this->githubAPIResult = $this->githubAPIResult[0];
// 		}
// 	}

// 	// Push in plugin version information to get the update notification
// 	public function setTransitent($transient) {
// 		// code here
// 		// If we have checked the plugin data before, don't re-check
// 		if (empty($transient->checked)) {
// 			return $transient;
// 		}

// 		// Get plugin & GitHub release information
// 		$this->initPluginData();
// 		$this->getRepoReleaseInfo();

// 		// Check the versions if we need to do an update
// 		$doUpdate = version_compare($this->githubAPIResult->tag_name, $transient->checked[$this->slug]);

// 		// Update the transient to include our updated plugin data
// 		if ($doUpdate == 1) {
// 			$package = $this->githubAPIResult->zipball_url;

// 			// Include the access token for private GitHub repos
// 			if (!empty($this->accessToken)) {
// 				$package = add_query_arg(array("access_token" => $this->accessToken), $package);
// 			}

// 			$obj                              = new stdClass();
// 			$obj->slug                        = $this->slug;
// 			$obj->new_version                 = $this->githubAPIResult->tag_name;
// 			$obj->url                         = $this->pluginData["PluginURI"];
// 			$obj->package                     = $package;
// 			$transient->response[$this->slug] = $obj;
// 		}

// 		return $transient;
// 	}

// 	// Push in plugin version information to display in the details lightbox
// 	public function setPluginInfo($false, $action, $response) {
// 		// code ehre
// 		// Get plugin & GitHub release information
// 		$this->initPluginData();
// 		$this->getRepoReleaseInfo();

// 		// If nothing is found, do nothing
// 		if (empty($response->slug) || $response->slug != $this->slug) {
// 			return false;
// 		}

// 		// Add our plugin information
// 		$response->last_updated = $this->githubAPIResult->published_at;
// 		$response->slug         = $this->slug;
// 		$response->plugin_name  = $this->pluginData["Name"];
// 		$response->version      = $this->githubAPIResult->tag_name;
// 		$response->author       = $this->pluginData["AuthorName"];
// 		$response->homepage     = $this->pluginData["PluginURI"];

// // This is our release download zip file
// 		$downloadLink = $this->githubAPIResult->zipball_url;

// // Include the access token for private GitHub repos
// 		if (!empty($this->accessToken)) {
// 			$downloadLink = add_query_arg(
// 				array("access_token" => $this->accessToken),
// 				$downloadLink
// 			);
// 		}
// 		$response->download_link = $downloadLink;

// 		// We're going to parse the GitHub markdown release notes, include the parser
// 		require_once plugin_dir_path(__FILE__) . "parsedown.php";

// 		// Create tabs in the lightbox
// 		$response->sections = array(
// 			'description' => $this->pluginData["Description"],
// 			'changelog'   => class_exists("Parsedown")
// 			? Parsedown::instance()->parse($this->githubAPIResult->body)
// 			: $this->githubAPIResult->body,
// 		);

// 		// Gets the required version of WP if available
// 		$matches = null;
// 		preg_match("/requires:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches);
// 		if (!empty($matches)) {
// 			if (is_array($matches)) {
// 				if (count($matches) > 1) {
// 					$response->requires = $matches[1];
// 				}
// 			}
// 		}

// // Gets the tested version of WP if available
// 		$matches = null;
// 		preg_match("/tested:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches);
// 		if (!empty($matches)) {
// 			if (is_array($matches)) {
// 				if (count($matches) > 1) {
// 					$response->tested = $matches[1];
// 				}
// 			}
// 		}

// 		return $response;
// 	}

// 	// Perform additional actions to successfully install our plugin
// 	public function postInstall($true, $hook_extra, $result) {
// 		// code here
// 		// Get plugin information
// 		$this->initPluginData();

// 		// Remember if our plugin was previously activated
// 		$wasActivated = is_plugin_active($this->slug);

// 		// Since we are hosted in GitHub, our plugin folder would have a dirname of
// 		// reponame-tagname change it to our original one:
// 		global $wp_filesystem;
// 		$pluginFolder = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . dirname($this->slug);
// 		$wp_filesystem->move($result['destination'], $pluginFolder);
// 		$result['destination'] = $pluginFolder;

// 		// Re-activate plugin if needed
// 		if ($wasActivated) {
// 			$activate = activate_plugin($this->slug);
// 		}

// 		return $result;
// 	}
// }

// if (is_admin()) {
// 	new BFIGitHubPluginUpdater(__FILE__, 'thailoeduardo', "testes-github-plugin-updater", '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');
// }

// $_chave = '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';

// if ((string) $_chave !== '') {
// 	include_once plugin_dir_path(__FILE__) . 'PDUpdater.php';
// 	$updater = new ThailoPDUpdater(__FILE__);
// 	$updater->set_username('thailoeduardo');
// 	$updater->set_repository('testes-github-plugin-updater');
// 	$updater->authorize($_chave);
// 	$updater->initialize();
// }

// class PDUpdater {
// 	private $file;
// 	private $plugin;
// 	private $basename;
// 	private $active;
// 	private $username;
// 	private $repository;
// 	private $authorize_token;
// 	private $github_response;

// 	public function __construct($file) {
// 		$this->file = $file;
// 		add_action('admin_init', [$this, 'set_plugin_properties']);

// 		return $this;
// 	}

// 	public function set_plugin_properties() {
// 		$this->plugin   = get_plugin_data($this->file);
// 		$this->basename = plugin_basename($this->file);
// 		$this->active   = is_plugin_active($this->basename);
// 	}

// 	public function set_username($username) {
// 		$this->username = $username;
// 	}

// 	public function set_repository($repository) {
// 		$this->repository = $repository;
// 	}

// 	public function authorize($token) {
// 		$this->authorize_token = $token;
// 	}

// 	private function get_repository_info() {
// 		if (is_null($this->github_response)) {
// 			$request_uri = sprintf('https://api.github.com/repos/%s/%s/releases', $this->username, $this->repository);

// 			// Switch to HTTP Basic Authentication for GitHub API v3
// 			$curl = curl_init();

// 			curl_setopt_array($curl, [
// 				CURLOPT_URL            => $request_uri,
// 				CURLOPT_RETURNTRANSFER => true,
// 				CURLOPT_ENCODING       => "",
// 				CURLOPT_MAXREDIRS      => 10,
// 				CURLOPT_TIMEOUT        => 0,
// 				CURLOPT_FOLLOWLOCATION => true,
// 				CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
// 				CURLOPT_CUSTOMREQUEST  => "GET",
// 				CURLOPT_HTTPHEADER     => [
// 					"Authorization: token " . $this->authorize_token,
// 					"User-Agent: PDUpdater/1.2.3",
// 				],
// 			]);

// 			$response = curl_exec($curl);

// 			curl_close($curl);

// 			$response = json_decode($response, true);

// 			var_dump($response);
// 			die;

// 			if (is_array($response)) {
// 				$response = current($response);
// 			}

// 			if ($this->authorize_token) {
// 				$response['zipball_url'] = add_query_arg('access_token', $this->authorize_token, $response['zipball_url']);
// 			}

// 			$this->github_response = $response;
// 		}
// 	}

// 	public function initialize() {
// 		add_filter('pre_set_site_transient_update_plugins', [$this, 'modify_transient'], 10, 1);
// 		add_filter('plugins_api', [$this, 'plugin_popup'], 10, 3);
// 		add_filter('upgrader_post_install', [$this, 'after_install'], 10, 3);
// 	}

// 	public function modify_transient($transient) {
// 		if (property_exists($transient, 'checked')) {
// 			if ($checked = $transient->checked) {
// 				$this->get_repository_info();

// 				$out_of_date = version_compare($this->github_response['tag_name'], $checked[$this->basename], 'gt');

// 				if ($out_of_date) {
// 					$new_files = $this->github_response['zipball_url'];
// 					$slug      = current(explode('/', $this->basename));

// 					$plugin = [
// 						'url'         => $this->plugin['PluginURI'],
// 						'slug'        => $slug,
// 						'package'     => $new_files,
// 						'new_version' => $this->github_response['tag_name'],
// 					];

// 					$transient->response[$this->basename] = (object) $plugin;
// 				}
// 			}
// 		}

// 		return $transient;
// 	}

// 	public function plugin_popup($result, $action, $args) {
// 		if ($action !== 'plugin_information') {
// 			return false;
// 		}

// 		if (!empty($args->slug)) {
// 			if ($args->slug == current(explode('/', $this->basename))) {
// 				$this->get_repository_info();

// 				$plugin = [
// 					'name'              => $this->plugin['Name'],
// 					'slug'              => $this->basename,
// 					'requires'          => '5.3',
// 					'tested'            => '5.4',
// 					'version'           => $this->github_response['tag_name'],
// 					'author'            => $this->plugin['AuthorName'],
// 					'author_profile'    => $this->plugin['AuthorURI'],
// 					'last_updated'      => $this->github_response['published_at'],
// 					'homepage'          => $this->plugin['PluginURI'],
// 					'short_description' => $this->plugin['Description'],
// 					'sections'          => [
// 						'Description' => $this->plugin['Description'],
// 						'Updates'     => $this->github_response['body'],
// 					],
// 					'download_link'     => $this->github_response['zipball_url'],
// 				];

// 				return (object) $plugin;
// 			}
// 		}

// 		return $result;
// 	}

// 	public function after_install($response, $hook_extra, $result) {
// 		global $wp_filesystem;

// 		$install_directory = plugin_dir_path($this->file);
// 		$wp_filesystem->move($result['destination'], $install_directory);
// 		$result['destination'] = $install_directory;

// 		if ($this->active) {
// 			activate_plugin($this->basename);
// 		}

// 		return $result;
// 	}
// }