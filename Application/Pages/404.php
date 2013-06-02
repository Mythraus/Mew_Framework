<?php

	$this->Views->Assign('Title', '404!');
	$this->Views->Assign('IP', $_SERVER['REMOTE_ADDR']);
	$this->Views->Draw('404');