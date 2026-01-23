<?php
spl_autoload_register(function($className) {
$file = dirname(__DIR__) . '\\' . $className . '.php';
		$file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
		if (file_exists($file)) {
			include $file;
		}else{
			$fileu = str_replace(CURRENT_FOLDER, $_ENV['CURRENT_UPATH'], $file);	
			if (file_exists($fileu)) {
				include $fileu;
			}else{
				$fileu = str_replace(CURRENT_FOLDER, $_ENV['CURRENT_PATH'], $file);	
				if (file_exists($fileu)) {
					include $fileu;
				}
			}
		}
	
});
