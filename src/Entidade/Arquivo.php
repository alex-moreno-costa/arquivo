<?php

namespace Alex\Entidade;

/**
 * Description of Arquivo
 *
 * @author alex
 */
class Arquivo
{
    protected $nome;
    protected $tamanho;
    protected $extensao;
    protected $mimeType;
    protected $nomeBase;
    protected $diretorio;
    protected $caminhoCompleto;
    
    public function __construct($arquivo)
    {
        if (!is_file($arquivo)) {
            throw new \InvalidArgumentException('O caminho informado (%s) não é um arquivo valido', $arquivo);
        }
        
        $this->desmembrarArquivo($arquivo);
    }
    
    protected function desmembrarArquivo($arquivo)
    {
        $pathinfo = pathinfo($arquivo);
        $this->nome = $pathinfo['filename'];
        $this->extensao = $pathinfo['extension'];
        $this->nomeBase = $pathinfo['basename'];
        $this->diretorio = $pathinfo['dirname'];
        $this->tamanho = filesize($arquivo);
        $this->mimeType = mime_content_type($arquivo);
        $this->caminhoCompleto = realpath($arquivo);
    }
    
    public function getNome()
    {
        return $this->nome;
    }

    public function getTamanho()
    {
        return $this->tamanho;
    }

    public function getExtensao()
    {
        return $this->extensao;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function getNomeBase()
    {
        return $this->nomeBase;
    }

    public function getDiretorio()
    {
        return $this->diretorio;
    }

    public function getCaminhoCompleto()
    {
        return $this->caminhoCompleto;
    }
    
    public function renomear($novoNome)
    {
        $this->nome = filter_var($novoNome, FILTER_SANITIZE_STRING);
        $novoArquivo = $this->diretorio . '/' . $this->nome . '.' . $this->extensao;
        rename($this->caminhoCompleto, $novoArquivo);
        $this->desmembrarArquivo($novoArquivo);
        return true;
    }
    
    public function alterarExtensao($novaExtensao)
    {
        $this->extensao = filter_var($novaExtensao, FILTER_SANITIZE_STRING);
        $novoArquivo = $this->diretorio . '/' . $this->nome . '.' . $this->extensao;
        rename($this->caminhoCompleto, $novoArquivo);
        $this->desmembrarArquivo($novoArquivo);
        return true;
    }
}
