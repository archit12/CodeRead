<?php 
class CodeRead {

	protected $LANGUAGES = array(
		1 => ".c", 
		2 => ".cpp", 
		3 => ".java"
	);

	// Repositories/File Object
	protected $file;

	// The programming language in which code is written in the image
	protected $language;

	public function __construct($file, $language = 1) {
		$this->file       = $file;
		$this->language   = $language;
	}

	

	public function recognizeText($imageFile)
	{
		require_once "TesseractOCR/TesseractOCR.php";
		require_once "Repositories/CR_File.php";

		// Recognize text from image
		$tesseract = new TesseractOCR($imageFile->filePath);
        $tesseract->setWhitelist(range('A','Z'), range('a', 'z'), range(0,9), '_-.,;"#<>()%{}[]= ');

        $txt = $tesseract->recognize();

        // Save text file
        // public/output/code_filename.ext
        $codeFilePath = "public/output/code_" . $imageFile->fileName . $this->LANGUAGES[$this->language];
        $recognizedCodeFile = new CR_File($codeFilePath);
        $recognizedCodeFile->write($txt);
        return $recognizedCodeFile;
	}

	public function preprocessImage($inputImage)
	{
		require_once "Matlab/Matlab.php";

		$matlab = new Matlab($inputImage);
		$preprocessedImage = $matlab->preprocess();
		return $preprocessedImage;
	}

	public function correctErrorsInCode($codeFile)
	{
		require_once "Python/PostProcessor.php";
		$postProcessor = new PostProcessor($codeFile);
		$codeFile = $postProcessor->postProcess();
		return $codeFile;
	}

	public function compileCode($language, $codeFile)
	{
		switch ($language) {
			case '1':
				require_once "Compiler/CCompiler.php";
				$cCompiler = new CCompiler($codeFile);
				$output = $cCompiler->compile();
				break;
			
			case '2':
				require_once "Compiler/CppCompiler.php";
				$cppCompiler = new CppCompiler($codeFile);
				$cppCompiler->compile();
				break;

			case '3':
				require_once "Compiler/JavaCompiler.php";
				$javaCompiler = new JavaCompiler($codeFile);
				$javaCompiler->compile();
				break;

		}
		return $output;
	}

	public function execute()
	{
		$preprocessedImage = $this->preprocessImage($this->file);
		$codeFile          = $this->recognizeText($this->file);
		$newCodeFile       = $this->correctErrorsInCode($codeFile);

		$result = new stdClass;
		$result->code   = file_get_contents($newCodeFile->filePath);
		$result->output = $this->compileCode($this->language, $newCodeFile);
		return $result;
	}
}