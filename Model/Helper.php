<?php
/**
 * Webkul Software.
 *
 * @package   Webkul_CodeGenerator
 * @author    Ashutosh Srivastva
 */

namespace Webkul\CodeGenerator\Model;

use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\DocBlock\Tag;
use Magento\Framework\Simplexml\Element;
use Magento\Framework\Simplexml\Config;

class Helper {

    public function saveFile($path, $content)
    {
        file_put_contents(
            $path,
            $content
        );
    }

    public function getHeadDocBlock($moduleName)
    {
        return DocBlockGenerator::fromArray([
            'shortDescription' => 'Webkul Software.',
            'tags'             => [
                new Tag\GenericTag('category', 'Webkul'),
                new Tag\GenericTag('package', $moduleName),
                new Tag\GenericTag('author', 'Webkul'),
                new Tag\GenericTag('copyright', 'Copyright (c) Webkul Software Private Limited (https://webkul.com)'),
                new Tag\LicenseTag('https://store.webkul.com/license.html', '')
               
            ],
        ]);
    }

    /**
     * Map valid database types
     *
     * @param string $type
     * @return string
     */
    public function getReturnType($type = 'default')
    {
        $validTypes = [
            'varchar' => 'string',
            'text' => 'string',
            'smallint' => 'int',
            'int' => 'int',
            'integer' => 'int',
            'decimal' => 'float',
            'boolean' => 'bool'
        ];
        return isset($validTypes[$type]) ? $validTypes[$type] : 'string';
    }

    public static function createDirectory($dirPath, $permission = 0777)
    {
        if (!is_dir($dirPath)) {
            mkdir($dirPath, $permission, true);
        }
    }

    public function getTemplatesFiles($template)
    {
        return file_get_contents(dirname( dirname(__FILE__) ) . DIRECTORY_SEPARATOR. $template);
    }

    /**
     * Get the Di.xml file
     *
     * @param string $etcDirPath
     * @return string
     */
    public function getDiXmlFile($etcDirPath)
    {
        $diFilePath = $this->getDiXmlFilePath($etcDirPath);
        if (file_exists($diFilePath)) {
            return $diFilePath;
        } else {
            return $diXml = $this->createDiXmlFile($etcDirPath);
        }
    }

    /**
     * Get the actual path of di.xml
     *
     * @param string $etcDirPath
     * @return string
     */
    private function getDiXmlFilePath($etcDirPath)
    {
        return $etcDirPath.DIRECTORY_SEPARATOR.'di.xml';
    }
    
    /**
     * Create di.xml
     *
     * @param string $etcDirPath
     * @return string
     */
    private function createDiXmlFile($etcDirPath)
    {
        $diXmlFilePath = $this->getDiXmlFilePath($etcDirPath);
        $diXmlData = $this->getTemplatesFiles('templates/di.xml.dist');
        $this->saveFile($diXmlFilePath, $diXmlData);
        return $diXmlFilePath;
    }
}
