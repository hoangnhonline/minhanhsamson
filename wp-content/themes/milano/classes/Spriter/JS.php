<?php

class Spriter_JS
{
	private $_defaultSpriteName = 'sprite.js';
	private $_defaults = array(
		'recursive'=>false,
		'excludes' => array('.', '..'),
		'addTryCatch' => true,
		'log' => false,
		'dev' => true,
		'sef' => true, // Wrap sprite in Self Executing Function
	);
	private $_options = array();


	public function __construct($config = array())
	{
		$this->_options = array_merge($this->_defaults, $config);
		if(is_array($config['excludes']))
			$this->_options['excludes'] = array_merge($this->_defaults['excludes'], $config['excludes']);
	}

	public function get($folder = './', $spriteName = false)
	{
		try 
		{
			if (!$spriteName) $spriteName = $this->_defaultSpriteName;
			if ($this->_options['dev'] &&
				$this->_getLastModFile($folder) != $folder . '/' .$spriteName &&
				$this->make($folder, $spriteName))
				{
					$spriteName .= '?' . date("ymdHis");
				}
			
			return $spriteName;
		}
		catch (Exception $e)
		{
			return false;
		}
	}


	public function make($folder = './', $spriteName = false)
	{
		try 
		{
			if(!is_dir($folder))
				throw new Exception("invalid directory name");
			
			$spriteName = (!$spriteName) ? $this->_defaultSpriteName : $spriteName;
			$this->_options['excludes'][] = $spriteName;
			
			$contentStart = "// last updated " . date("Y-m-d H:i:s") . "\n\n";
			
			$content = $this->_getDirContent($folder);

			if($content == '')
				throw new Exception("no js files if folder " . $folder);
				
			$content = ($this->_options['sef']) ? "(function( $ ) {\n\n" . $content . "\n})( jQuery );" : $content;
			
			file_put_contents( $folder . '/' . $spriteName, $contentStart . $content );
			if ($this->_options['log']) 
				echo 'spriting folder ' . $folder . ' success';
			return true;
		} 
		catch (Exception $e)
		{
			if ($this->_options['log'])
				echo 'sprite making error: ' . $e->getMessage() . '<br /><br />';
			else
				return false;
		}
	}

	private function _getDirContent($dirpath)
	{
		$dirContent = '';
		$files = scandir($dirpath);
		foreach ($files as $value) 
		{
			if(	in_array($value, $this->_options['excludes'])) continue;
			
			$filePath = $dirpath . '/' . $value;
			
			if(is_dir($filePath)){
				if($this->_options['recursive']) continue;
				$dirContent .= $this->_getDirContent($filePath);
			} else {
				if (substr($value, strlen($value) - 3) != '.js') continue;
				if ($this->_options['log']) echo $filePath . '<br /><br />';

				$preFile = '// file ' . $value . " start\n\n";
				$preFile .= ($this->_options['addTryCatch']) ? "try { \n" : '';

				$postFile = ($this->_options['addTryCatch']) ? "} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file " . $value . "'); }\n\n" : '';
				$postFile .= "// file " . $value . " end\n\n";

				$dirContent .= $preFile . file_get_contents ( $filePath )."\n" . $postFile;
			}
		}
		return $dirContent;
	}

	private function _getLastModFile($dir)
	{
		$files = glob($dir . "/*.js");
		if (!count($files))
			throw new Exception("no js files if folder " . $folder);
		$files = array_combine($files, array_map("filemtime", $files));

		@arsort($files);


		return @key($files);
	}
}
?>