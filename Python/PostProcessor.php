<?php

class PostProcessor {
	protected $inputFile;

	protected $outputFile;

	public function __construct($inputFile)
	{
		$this->inputFile  = $inputFile;
		$outputFilePath = 'public/output/postprocess_' . $this->inputFile->getFullFileName();
		
		require_once "Repositories/CR_File.php";
		$this->outputFile = new CR_File($outputFilePath);
	}

	public function postProcess()
	{
		$command = $this->generateCommand();
		exec($command);
		return $this->outputFile;
	}

	public function generateCommand()
	{
		$inputFileName  = $this->inputFile->filePath;
		$outputFileName = $this->outputFile->filePath;
		return "python PostBeforeAdjust.py $inputFileName $outputFileName";
	}
}