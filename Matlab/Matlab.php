<?php

class Matlab {

	protected $inputFile;

	protected $outputFile;

	public function __construct($inputImage)
	{
		$this->inputFile  = $inputImage;
		$outputImagePath = 'public/output/preprocess_' . $inputImage->getFullFileName();

		require_once "Repositories/CR_File.php";
		$this->outputFile = new CR_File($outputImagePath);
	}

	public function preprocess()
	{
		$command = $this->generateCommand();
		exec($command);
		return $this->outputFile;
	}

	public function generateCommand()
	{
		$inputFilePath  = $this->inputFile->filePath;
		$outputFilePath = $this->outputFile->filePath;
		return "matlab -nojvm -nodesktop -nodisplay -r \"Preprocess('$inputFilePath','$outputFilePath');exit\"";
	}

}