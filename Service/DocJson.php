<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 17/12/15
 * Time: 09:30
 */

namespace AslakStudio\DocBundle\Service;


use ReflectionMethod;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DocJson
{
    const DOC_DIR = "doc/";
    /**
     * @var ContainerInterface
     */
    protected $container;

    private $name;

    /**
     * @var ReflectionMethod
     */
    private $method;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function extract($name, ReflectionMethod $method)
    {
        $this->name = $name;
        $this->method = $method;
        $file = $this->getFile();
        if(file_exists($file))
        {
            return file_get_contents($file);
        }
        return null;
    }

    private function getFile()
    {
        $doc_dir = $this->container->get('kernel')->getRootDir()."/".self::DOC_DIR;
        $route_dir_temp = str_replace("Controller","", $this->method->class);
        $route_dir = str_replace("\\","/",str_replace("\\\\","\\",$route_dir_temp));
        $explode_route = explode("/",$route_dir);
        end($explode_route);
        $explode_route[key($explode_route)] = strtolower($explode_route[key($explode_route)]);
        $route_dir = implode("/",$explode_route);
        return $doc_dir.$route_dir."_".$this->name.".json";
    }
}