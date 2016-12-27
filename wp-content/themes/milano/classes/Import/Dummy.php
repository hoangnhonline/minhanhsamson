<?php

class Import_Dummy
{
	
	const RESTARAUNT	= 'restaraunt';
	const HOTEL			= 'hotel';
	const EXTREME		= 'extreme';
	
	
	private $dummy_file = 'milano.dummy.xml';

	private $dummy_folder = 'dummy';
	
	private $install_type = '';

	private $importer_error = false;
	private $response = '';

	private $old_error_handler;
	private $old_error_reporting;
	


	function __construct($intall_type)
	{
		$this->setInstallType($intall_type);
	}
	

	public function run()
	{
		if( $this->isParentClassExist() )
		{
			if( $this->isDummyFile())
			{
				defined('IMPORT_DEBUG') || define( 'IMPORT_DEBUG', false );

				ob_start();
				$this->setErrorHandler();

				$result = $this->importFromFile();

				if(is_wp_error($result))
				{
					$this->response('error',  $result->get_error_message());
				}
				else
				{
					$this->importThemeManual($this->getInstallType());
					$this->markAsImported();
					$this->admin_init();
				}

				$data = ob_get_clean();

				$this->restoreErrorHandler();
				if(strlen($data))
				{
					$this->response('error', $data);
				}
			}
			else
			{
				$this->response('error', "The XML file containing the dummy content is not available or could not be read in <pre>" . get_template_directory() . "/backend/dummy/</pre>");
			}
		}
		else
		{
			$this->response('error', "Import error! try to import dummy content manually from <pre>" . get_template_directory() . "/backend/dummy/</pre>");
		}
		$this->response('success');
	}

	private function isParentClassExist()
	{
		if (!class_exists('WP_Importer'))
		{
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if (file_exists($class_wp_importer))
			{
				require_once($class_wp_importer);
				return true;
			}
		}
		return false;
	}

	private function importFromFile()
	{
		$wp_import = new Import_Importer();
		$wp_import->fetch_attachments = false;
		$wp_import->import( $this->getDummyFilePath() );
	}

	private function importThemeManual($install_type)
	{
		foreach ($this->getThemeImportItems() as $itemClass)
		{
			$itemObj = new $itemClass($install_type);
			$itemObj->import();
		}
	}

	private function markAsImported()
	{
		update_option(SHORTNAME.'_dummy_install', "completed");
	}

	private function getThemeImportItems()
	{
		return array(
					'Import_Theme_Media',
					'Import_Theme_Menus',
					'Import_Theme_Options',
					'Import_Theme_Meta',
					'Import_Theme_Widgets',
				);
	}

	private function getDummyFileName()
	{
		switch($this->getInstallType())
		{
			case self::RESTARAUNT:
				return 'dummy_restaraunt.xml';
				break;
			case self::HOTEL:
				return 'dummy_hotel.xml';
				break;
			case self::EXTREME:
				return 'dummy_extreme.xml';
				break;
			default:
				return $this->dummy_file;
				break;
		}
	}

	private function getDummyDirName()
	{
		return $this->dummy_folder;
	}

	private function admin_init()
	{
		add_action( 'admin_init', array($this, 'wordpress_odin_importer_init'));
		$custom_stylesheet = new Custom_CSS_Style();
		$custom_stylesheet->reinit();
	}

	private function wordpress_odin_importer_init()
	{
		load_plugin_textdomain( 'wordpress-importer', false, get_template_directory(). '/backend/languages' );

		$GLOBALS['wp_import'] = new Import_Importer();
		register_importer( 'wordpress', 'WordPress', __('Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from a WordPress export file.', 'wordpress-importer'), array( $GLOBALS['wp_import'], 'dispatch' ) );
	}

	private function response($status, $data='')
	{
		$response = json_encode(array('status' => $status, 'data' => $data));
		header('content-type: application/json; charset=utf-8');
		die ($response);
	}

	private function isDummyFile()
	{
		return is_file($this->getDummyFilePath());
	}

	private function getDummyFilePath()
	{
		return get_template_directory(). "/classes/Import". DIRECTORY_SEPARATOR. $this->getDummyFileName();
	}
	
	private function setInstallType($type)
	{
		$this->install_type = $type;
	}

	private function getInstallType()
	{
		return $this->install_type;
	}

	/**
	 * Set Custom Error handler and error_reporting level
	 */
	private function setErrorHandler()
	{
		$this->old_error_reporting = error_reporting();
//		error_reporting(0);
		error_reporting(E_ALL);
		$this->old_error_handler = set_error_handler(array($this, 'myErrorHandler'));
	}

	
	/**
	 * Theme Import custom error handler function
	 * @param type $errno
	 * @param type $errstr
	 * @param type $errfile
	 * @param type $errline
	 * @return boolean
	 */
	public function myErrorHandler($errno, $errstr, $errfile, $errline)
	{
		if (!(error_reporting() & $errno))
		{
			// This error code is not included in error_reporting
			return;
		}

		switch ($errno)
		{
			case E_USER_ERROR:
				echo "<b>Import ERROR</b>: $errstr<br />\n";
				echo "Fatal error on line $errline in file $errfile";
				echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
				echo "<hr/><br />\n";

				break;

			case E_USER_WARNING:
				echo "<b>Import WARNING</b>: $errstr<br />\n";
				echo "On line $errline in file $errfile";
				echo "<hr/><br />\n";
				break;

			case E_USER_NOTICE:
				echo "<b>Import NOTICE</b>: $errstr<br />\n";
				echo "On line $errline in file $errfile";
				echo "<hr/><br />\n";
				break;

			default:
				echo "Unknown error type[$errno]: $errstr<br />\n";
				echo "On line $errline in file $errfile";
				echo "<hr/><br />\n";
				break;
		}

		/* Don't execute PHP internal error handler */
		return true;
	}

	/**
	 * restore previus error handler
	 */
	private function restoreErrorHandler()
	{
		error_reporting($this->old_error_reporting);
		if(!is_null($this->old_error_handler))
		{
			set_error_handler($this->old_error_handler);
		}
		else
		{
			restore_error_handler();
		}
	}
}
?>