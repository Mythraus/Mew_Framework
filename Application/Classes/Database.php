<?php

	class Database extends PDO
	{
		public function __construct($Host, $User, $Pass, $Data, $Port)
		{
			try
			{
				// This just makes it easier to connect as it does the dsn in the construct now.
				// This will need editing if you wish to use a different driver.
				parent::__construct("mysql:dbname=".$Data.";host=".$Host.";port=".$Port.";", $User, $Pass);
			}
			catch(PDOException $E)
			{
				print $E->getMessage();
			}
		}
	}