<?php

require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit_Framework_TestCase as PHPUnit;
use Alex\Entidade\Arquivo;

class ArquivoTest extends PHPUnit
{
    protected function criarArquivo($filename)
    {
        $arquivo = __DIR__ . '/../arquivos/' . $filename;
        $handle = fopen($arquivo, 'w+');
        fclose($handle);
        return $arquivo;
    }
    
    public function testCriarArquivo()
    {
        $filename = $this->criarArquivo('arquivo.txt');
        unlink($filename);
    }
    
    public function testVerificaSeAClasseReconheceOArquivo()
    {
        $arquivo = $this->criarArquivo('arquivo.txt');
        
        $file = new Arquivo($arquivo);
        $this->assertInstanceOf(
                'Alex\Entidade\Arquivo', 
                $file, 
                sprintf('O caminho informado (%s) não é un arquivo', $arquivo)
                );
        
        $this->assertEquals('arquivo', $file->getFilename());
        $this->assertEquals('txt', $file->getExtension());
        $this->assertEquals('arquivo.txt', $file->getBasename());
        $this->assertEquals(__DIR__ . '/../arquivos', $file->getPath());
        unlink($arquivo);
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testNaoDeveReconhecerComoUmArquivoValido()
    {
        $filename = __DIR__;
        $file = new Arquivo($filename);
    }
    
    public function testRenameFile()
    {
        $filename = $this->criarArquivo('arquivo.txt');
        $file = new Arquivo($filename);
        $file->rename('modificado');
        $this->assertEquals('modificado', $file->getFilename());
        unlink($file->getRealPath());
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testDelete()
    {
        $filename = $this->criarArquivo('arquivo.txt');
        $file = new Arquivo($filename);
        $this->assertTrue($file->delete());
        unset($file);
        $file = new Arquivo($filename);
    }
}