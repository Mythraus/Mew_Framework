<?php

	class Bootstrap
	{
		public $Config;
		public $Database;
		public $Views;

		public $Name;
		public $Link;
		public $Page;

		/* Determining what occurs when the class is initiated */

		public function __construct()
		{
			$this->LoadConfig();
			$this->GetClasses();
			$this->Database = new Database
			(
				$this->Config['Mysql.Host'], 
				$this->Config['Mysql.User'], 
				$this->Config['Mysql.Pass'], 
				$this->Config['Mysql.Data'], 
				$this->Config['Mysql.Port']
			);
			$this->Views = new RainTPL();
			$this->SetVars();
			$this->GetPage();
		}

		/* Loading Section */

		// Loading the config.ini from it's folder and assigning it to the $Config var in an array.
		private function LoadConfig()
		{
			$Array = parse_ini_file("Application/Configuration/Config.ini");
			foreach($Array as $Key => $Value)
			{
				$this->Config[$Key] = $Value;
			}
		}

		// Basic file loading, checks if page exists and requires it.
		private function LoadPage()
		{
			if(file_exists("Application/Pages/".$this->Page.".php"))
			{
				require_once "Application/Pages/".$this->Page.".php";
			}
			else
			{
				require_once "Application/Pages/404.php";
			}
		}

		/* Getting Section */

		// Retrieves classes, warning if you wish to use other classes make sure they have static functions.
		// Disregard the top if you plan to instantiate them within the pages.
		private function GetClasses()
		{
			$Array = glob("Application/Classes/*.php");
			foreach($Array as $Key)
			{
				require_once $Key;
			}
		}

		// Simple page nabber by using the $_GET variable.
		private function GetPage()
		{
			if(!isset($_GET['page']) || $_GET['page'] == "index.php" || empty($_GET['page']))
			{
				$this->Page = "Index";
			}
			else
			{
				$this->Page = rtrim($_GET['page'], '/');
			}
				$this->LoadPage();
				Helpers::LoadHelpers($this->Page, $this->Database);
		}

		/* Setting Section */

		// Just setting RainTPL and some minor variables, pretty easy to read.
		private function SetVars()
		{
			$this->Name = $this->Config['Site.Name'];
			$this->Link = $this->Config['Site.Link'];
			$this->Views->Configure('tpl_dir', $this->Config['RainTPL.Dir']);
			$this->Views->Configure('tpl_ext', $this->Config['RainTPL.Ext']);
			$this->Views->Assign('Name', $this->Name);
			$this->Views->Assign('Link', $this->Link);
			$this->Views->Assign('Page', $this->Page);
			$this->Views->Assign('Footer', 'Kerpywrite MewFramework all roights reservd thx to raintpl for da templatin');
		}
	}