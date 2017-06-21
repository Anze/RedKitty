<?php
//
//  autoload.php
//  redkitty
//
//  Created by Anze on 2017-06-21.
//  Copyright 2017 0804Team. All rights reserved.
//  Licensed under MIT
//

	function __autoload($class) {
		require_once("src/$class.php");
	}

?>