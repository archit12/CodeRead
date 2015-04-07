<?php

require_once "ICompiler.php";

class CCompiler implements ICompiler{

    protected $inputFile;

    protected $outputFile;

    public function __construct($inputFile)
    {
        $this->inputFile = $inputFile;
        $outputPath = "public/compiled/" . $inputFile->fileName . ".exe";
        
        require_once "Repositories/CR_File.php";
        $file = new CR_File($outputPath);
        $this->outputFile = $file;
    }

    public function compile()
    {
        $command = $this->generateCommand();
        exec($command, $c, $check);

        if (!$check) {
            $outputFilePath = $this->outputFile->filePath;
            $command = $outputFilePath;
            exec('"' . $command.'"', $output);
            print_r($output);
        }
        else {
            system("$command 2>&1");
        }
    }

    public function generateCommand()
    {
        $inputFilePath  = $this->inputFile->filePath;
        $outputFilePath = $this->outputFile->filePath;

        return "gcc $inputFilePath -o $outputFilePath";
    }
}