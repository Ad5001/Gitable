<?php


namespace Ad5001\Gitable;



use pocketmine\Server;


use pocketmine\Player;



use Ad5001\Gitable\Main;







class Windows extends GitClient {
	
	
	/*
	Exec's a git request with defined args
	@param     $args    string
	*/
	public function gitExec(string $args) : string {
		proc_open(
		    "cd " . $this->dir,
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $a
		  );
		$process = proc_open(
		    "git " . $args,
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $pipes
		  );
		  proc_open(
		    "cd " . DEFAULT_GIT_DIR,
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $a
		  );
		if ($process !== false) {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
			proc_close($process);
			
			return (string) $stdout;
		} else {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
			return "Error while executing command "."git " . $args . ": $stderr";
		}
	}


	/*
	Changes current directory
	@param     $path    string
	*/
	public function cd(string $path): string {
		if(is_dir($this->dir . $path)) {
			$this->dir .= $path;
			if(substr($this->dir, strlen($this->dir) - 1) !== "/") {
				$this->dir .= "/";
			}
			return "§aPath set to $this->dir";
		} elseif(is_dir($path)) {
			$this->dir = $path;
			if(substr($this->dir, strlen($this->dir) - 1) !== "/") {
				$this->dir .= "/";
			}
			return "§aPath set to $path";
		} else {
			return "§4Directory $path not found !";
		}
	}


	/*
	Return all files and dirs from the current directory
	*/
	public function ls() : string {
		proc_open(
		    "cd " . $this->dir,
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $a
		);
		$whereIsCommand = (PHP_OS == 'WINNT') ? 'dir' : 'ls';
		
		$process = proc_open(
		    "$whereIsCommand $command",
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $pipes
		  );
		  proc_open(
		    "cd " . DEFAULT_GIT_DIR,
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $a
		  );
		if ($process !== false) {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
			proc_close($process);
			
			return $stdout;
		}
	}


	/*
	Checks if the executable exists.
	*/
	public function initcheck() {
		$this->executable = $this->main->getConfig()->get("executable_path");
		$process = proc_open(
		    '"$this->executable"'." --version",
		    array(
		      0 => array("pipe", "r"), //S		TDIN
		      1 => array("pipe", "w"), //S		TDOUT
		      2 => array("pipe", "w"), //S		TDERR
		    ),
		    $pipes
		  );
		if ($process !== false) {
			$stdout = stream_get_contents($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[1]);
			fclose($pipes[2]);
			proc_close($process);
			
			if(strpos($stdout, "git version") == false) {
				$this->main->getLogger()->critical("Executable wasn't found at path $this->executable. Be sure that you installed git and that the path in the config is the executable path.");
				$this->main->setEnabled(false);
			}
		}
	}


	
	
	
}
