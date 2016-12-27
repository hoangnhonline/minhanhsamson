<?php
class Envato_Theme_Updater
{
	protected $username;
	protected $apiKey;
	
	/**
	 * WP_Theme object
	 * @var WP_Theme 
	 */
	private $wp_theme = null;

	public function __construct($username, $apiKey, $authors)
	{
		// to debug
		// set_site_transient('update_themes',null);

		$this->username	= $username;
		$this->apiKey	= $apiKey;
		$this->authors	= $authors;
		
		$this->wp_theme	= wp_get_theme();
		
		add_filter("pre_set_site_transient_update_themes", array(&$this, "check"));
		add_filter('upgrader_pre_install', array(&$this, '_backup_theme'));
		
	}

	public function check($updates)
	{

		if ($this->authors && !is_array($this->authors))
		{
			$this->authors = array($this->authors);
		}

		if (!$this->username || !$this->apiKey || !isset($updates->checked))
			return $updates;

		$api = new Envato_Theme_Protected_API($this->username, $this->apiKey);

		add_filter("http_request_args", array(&$this, "http_timeout"), 10, 1);

		$purchased = $api->wp_list_themes(true);
		$installed = wp_get_themes();
		$filtered = array();


		foreach ($installed as $theme)
		{
			if ($this->authors && !in_array($theme->{'Author Name'}, $this->authors))
				continue;
			$filtered[$theme->Name] = $theme;
		}
		
		if (!isset($purchased['api_error']) || (isset($purchased['api_error']) && strlen($purchased['api_error']) == 0 ))
		{
			foreach ($purchased as $theme)
			{
				if (isset($filtered[$theme->theme_name]))
				{
					// gotcha, compare version now
					$current = $filtered[$theme->theme_name];
					if (version_compare($current->Version, $theme->version, '<'))
					{
						// bingo, inject the update
						if ($url = $api->wp_download($theme->item_id))
						{
							$update = array(
								"url" => "http://themeforest.net/item/theme/{$theme->item_id}",
								"new_version" => $theme->version,
								"package" => $url
							);

							$updates->response[$current->Stylesheet] = $update;
						}
					}
				}
			}
		}

		remove_filter("http_request_args", array(&$this, "http_timeout"));

		return $updates;
	}

	public function http_timeout($req)
	{
		// increase timeout for api request
		$req["timeout"] = 300;
		return $req;
	}

	public static function init($username = null, $apiKey = null, $authors = null)
	{
		new Envato_Theme_Updater($username, $apiKey, $authors);
	}

	public function _backup_theme()
	{
		if( $this->isBackupNeed())
		{
			$this->indexPhpCreate();
			
			$backup_errors = array();
			
			if($backup_file_name = $this->getBackupFileName())
			{
				$theme_backup = Envato_Theme_Backup::get_instance();

				$theme_backup->path = $this->getBackupDirPath();

				$theme_backup->root = get_template_directory();

				$theme_backup->archive_filename = $backup_file_name;

				if ((!is_dir($theme_backup->path()) && (!is_writable(dirname($theme_backup->path())) || !mkdir($theme_backup->path()) ) ) || !is_writable($theme_backup->path()))
				{
					array_push($backup_errors, 'Invalid backup path');
					return false;
				}

				if (!is_dir($theme_backup->root()) || !is_readable($theme_backup->root()))
				{
					array_push($backup_errors, 'Invalid root path');
					return false;
				}

				$theme_backup->backup();

				if (file_exists(Envato_Theme_Backup::get_instance()->archive_filepath()))
				{
					return true;
				}
				else
				{
					return $backup_errors;
				}
			}
		}
		return false;
	}
	
	/**
	 * Create index.php file in backup directory
	 */
	private function indexPhpCreate() {
		$path = $this->getBackupDirPath();
		$index_php = $path . 'index.php';
		
		/* Create the backups directory if it doesn't exist */
		if ( is_writable( dirname( $path ) ) && ! is_dir( $path ) )
		  mkdir( $path, 0755 );
		
		if ( ! file_exists( $index_php ) && is_writable( $path ) )
		{
			$contents[]	= '<?php';
			$contents[] = PHP_EOL;
			$contents[] = '// Silence is golden.';
			$contents[] = PHP_EOL;
			$contents[] = 'die();';
			$contents[] = PHP_EOL;
			$contents[] = '?>';
			
			file_put_contents($index_php, $contents);
		}
	}

	/**
	 * Check skip backup or it need<br/>
	 * if Skip option is checked then skip backup
	 * @return boolean
	 */
	private function isBackupNeed()
	{
		return  ! get_option(SHORTNAME . '_envato_skip_backup');
	}

	private function getBackupDirPath()
	{
		return WP_CONTENT_DIR . DIRECTORY_SEPARATOR . $this->getBackupDirName();
	}

	private function getBackupDirName()
	{
		return $this->getThemeName() . '-backups' . DIRECTORY_SEPARATOR   ;
	}
	
	/**
	 * Get current theme name
	 * @return mixed
	 */
	private function getThemeName() {
		$theme = $this->wp_theme;
		
		if($theme->Name) {
			return $theme->Name;
		}
		return false;
	}
	
	/**
	 * Get theme version
	 * @return mixed
	 */
	private function getThemeCurrentVersion() {
		$theme = $this->wp_theme;
		
		if($theme->Version) {
			return $theme->Version;
		}
		return false;
	}
	
	/**
	 * Get name for backup file
	 * @return mixed
	 */
	private function getBackupFileName() {
		$name = $this->getThemeName();
		$version = $this->getThemeCurrentVersion();
		if($name && $version) {
			return strtolower(sanitize_file_name($name . '-' . $version. '.backup.' . date('Y-m-d-H-i-s', time() + ( current_time('timestamp') - time() )) . '.zip'));
		}
		return false;
	}
}
?>