<?php

require __DIR__ . '/../../vendor/autoload.php';

use PHPUnit_Framework_TestCase as PHPUnit;
use Alex\Entidade\Arquivo;

class ArquivoTest extends PHPUnit
{
    public function testCriarArquivo()
    {
        $filename = __DIR__ . '/../arquivos/teste.txt';
        $handle = fopen($filename, 'w+');
        fclose($handle);
        unlink($filename);
    }
    
    public function testVerificaSeAClasseReconheceOArquivo()
    {
        $arquivo = __DIR__ . '/../arquivos/arquivo.txt';
        $handle = fopen($arquivo, 'w+');
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
        $this->assertEquals($file->getDiretorio(), __DIR__ . '/../arquivos', sprintf('O caminho do arquivo não bateu, %s', $file->getDiretorio()));
        $this->assertEquals($file->getNomeBase(), 'arquivo.txt', sprintf('O nome de base do arquivo não bateu, %s', $file->getNomeBase()));
        $this->assertEquals($file->getCaminhoCompleto(), realpath($arquivo), 'O caminho completo do arquivo não bateu');
        unlink($arquivo);
    }
    
    public function testRenomearArquivo()
    {
        $filename = __DIR__ . '/../arquivos/arquivo.txt';
        $handle = fopen($filename, 'w+');
        fclose($handle);
        
        $arquivo = new Arquivo($filename);
        
        $this->assertEquals($arquivo->getNome(), 'arquivo', sprintf('O nome do arquivo não bateu, %s', $arquivo->getNome()));
        $this->assertEquals($arquivo->getExtensao(), 'txt', sprintf('A extensão do arquivo não bateu, %s', $arquivo->getExtensao()));
        
        $arquivo->renomear('modificado');
        $this->assertEquals($arquivo->getNome(), 'modificado', sprintf('O nome do arquivo não bateu, %s', $arquivo->getNome()));
        $this->assertEquals($arquivo->getExtensao(), 'txt', sprintf('A extensão do arquivo não bateu, %s', $arquivo->getExtensao()));
        
        unlink($arquivo->getCaminhoCompleto());
    }
    
    public function testAlterarExtensaoDoArquivo()
    {
        $filename = __DIR__ . '/../arquivos/arquivo.txt';
        $handle = fopen($filename, 'w+');
        fclose($handle);
        
        $arquivo = new Arquivo($filename);
        
        $this->assertEquals($arquivo->getNome(), 'arquivo', sprintf('O nome do arquivo não bateu, %s', $arquivo->getNome()));
        $this->assertEquals($arquivo->getExtensao(), 'txt', sprintf('A extensão do arquivo não bateu, %s', $arquivo->getExtensao()));
        
        $arquivo->alterarExtensao('html');
        $this->assertEquals($arquivo->getNome(), 'arquivo', sprintf('O nome do arquivo não bateu, %s', $arquivo->getNome()));
        $this->assertEquals($arquivo->getExtensao(), 'html', sprintf('A extensão do arquivo não bateu, %s', $arquivo->getExtensao()));
        
        unlink($arquivo->getCaminhoCompleto());
    }
}