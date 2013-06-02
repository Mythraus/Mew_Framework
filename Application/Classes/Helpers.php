<?php

	class Helpers
	{
		private static $Helper;

		/* Basic plugin/helper class */

		public static function LoadHelpers($Page, $Database)
		{
			$Query = $Database->prepare("SELECT COUNT(*) FROM helpers WHERE helper_target_file=?");
			$Query->execute(Array($Page.".php"));
			$Result = $Query->fetchColumn();
			if($Result > 0)
			{
				$Query = $Database->prepare("SELECT helper_file_name,helper_class_name,helper_name FROM helpers WHERE helper_target_file=?");
				$Query->Execute(Array($Page.".php"));
				while($Fetch = $Query->fetch())
				{
					require_once "Application/Helpers/" . $Fetch["helper_file_name"];
					$Helper[$Fetch["helper_class_name"]] = new $Fetch["helper_class_name"];

					// Attempt to start the helper
					try
					{
						$Helper[$Fetch["helper_class_name"]]->Load($Database, $Fetch["helper_name"]);
					}
					catch(Exception $E)
					{
						echo $E->getMessage();
					}
				}
			}
		}
	}