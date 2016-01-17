<?php

require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit_Framework_TestCase as PHPUnit;
use Alex\Entidade\Arquivo;

class ArquivoTest extends PHPUnit
{
    public function testVerificaSeAClasseReconheceOArquivo()
    {
        $arquivo = realpath(__DIR__ . '/../arquivos/arquivo.txt');
        if (!$handle = fopen($arquivo, 'w+')) {
            echo 'não criou o arquivo';
        }
        fwrite($handle, 'conteudo');
        fclose($handle);
        
        $file = new Arquivo($arquivo);
        $this->assertInstanceOf(
                'Alex\Entidade\Arquivo', 
                $file, 
                sprintf('O caminho informado (%s) não é un arquivo', $arquivo)
                );
        
        $this->assertEquals($file->getNome(), 'arquivo', sprintf('O nome do arquivo não bateu, %s', $file->getNome()));
        $this->assertEquals($file->getExtensao(), 'txt', sprintf('A extensão do arquivo não bateu, %s', $file->getExtensao()));
        $this->assertEquals($file->getMimeType(), 'text/plain', sprintf('O mimeType do arquivo não bateu, %s', $file->getMimeType()));
        $this->assertEquals($file->getCaminho(), __DIR__ . '/..', sprintf('O caminho do arquivo não bateu, %s', $file->getCaminho()));
        $this->assertEquals($file->getNomeBase(), __DIR__ . '/..', sprintf('O nome de base do arquivo não bateu, %s', $file->getNomeBase()));
    }
    
    public function testRenomearArquivo()
    {
        $filename = 'renomear.txt';
        $handle = fopen($filename, 'w+');
        fwrite($handle, 'Arquivo para ser renomeado');
        fclose($handle);
        
        $arquivo = new Arquivo($filename);
        $this->assertEquals($arquivo->getNome(), 'renomear', sprintf('O nome do arquivo não bateu, %s', $arquivo->getNome()));
        $this->assertEquals($arquivo->getExtensao(), 'txt', sprintf('A extensão do arquivo não bateu, %s', $arquivo->getExtensao()));
        
        $arquivo->renomear('modificado');
        $this->assertEquals($arquivo->getNome(), 'modificado', sprintf('O nome do arquivo não bateu, %s', $arquivo->getNome()));
        $this->assertEquals($arquivo->getExtensao(), 'txt', sprintf('A extensão do arquivo não bateu, %s', $arquivo->getExtensao()));
        
        unlink($filename);
    }
}