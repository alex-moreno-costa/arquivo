<?php

namespace Alex\Entidade;

/**
 * Description of Arquivo
 *
 * @author alex
 */
class Arquivo extends \SplFileInfo
{
    protected $mimeType;
    
    public function __construct($filename)
    {
        parent::__construct($filename);
        
        if (!$this->isFile()) {
            throw new \InvalidArgumentException(sprintf('The given path %s is not a valid file', $filename));
        }
        
        $this->dismemberFile($filename);
    }
    
    protected function dismemberFile($filename)
    {
        $this->mimeType = mime_content_type($filename);
    }
    
    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function getFilename()
    {
        return pathinfo($this->getRealPath(), PATHINFO_FILENAME);
    }
    
    /**
     * Rename the file and re-builds the class with the new file
     * @param string $newName
     * @param string $newExtension
     * @return boolean
     */
    public function rename($newName, $extension = null)
    {
        $newName = filter_var($newName, FILTER_SANITIZE_STRING);
        $newExtension = (null === $extension) ? $this->getExtension() : filter_var(substr_replace('.', null, $extension), FILTER_SANITIZE_STRING);
        
        $newFile = realpath($this->getPath()) . '/' . $newName . '.' . $newExtension;
        
        if (!rename($this->getRealPath(), $newFile)) {
            throw new \RuntimeException(sprintf('The file %s cannot be rename', $this->getRealPath()));
        }
        
        $this->__construct($newFile);
        return true;
    }
    
    public function delete()
    {
        return unlink($this->getRealPath());
    }
    
    public function move($newDirectory)
    {
        
    }
    
    public function copy($newDirectory)
    {
        
    }
}
