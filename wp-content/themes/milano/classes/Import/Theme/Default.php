<?php

abstract class Import_Theme_Default// implements Import_Theme_Item
{
	protected $install_type = '';
	
	public function __construct($type)
	{
		$this->setInstallType($type);
	}
	
	private function setInstallType($type)
	{
		$this->install_type = $type;
	}
	
	protected function getInstallType()
	{
		return $this->install_type;
	}
	
	public function import()
	{
		switch($this->getInstallType())
		{
			case Import_Dummy::RESTARAUNT:
				$this->import_restaraunt();
				break;
			case Import_Dummy::HOTEL:
				$this->import_hotel();
				break;
			case Import_Dummy::EXTREME:
				$this->import_extreme();
				break;			
		}
	}
	
	abstract public function import_restaraunt();
	abstract public function import_hotel();
	abstract public function import_extreme();
	
}
?>
