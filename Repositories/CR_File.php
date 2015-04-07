<?php 

class CR_File {

	public $filePath;

	public $fileName;

	public $fileExt;

	public function __construct($filePath)
	{
		$this->filePath  = $filePath;
		$names           = $this->getFileAttrib();
		$this->fileName  = $names[0];
		$this->fileExt   = "." . $names[1];
	}

	public function getFileAttrib()
	{
		return explode(".", basename($this->filePath));
	}

	public function getFullFileName() {
		return $this->fileName . $this->fileExt;
	}

	public function write($txt)
	{
		$myfile = fopen($this->filePath, "w") or die("Unable to open file!");
        fwrite($myfile, $txt);
        fclose($myfile);
	}

	public function read()
	{
		# code...
	}
}