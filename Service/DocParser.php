<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 17/12/15
 * Time: 09:22
 */

namespace AslakStudio\DocBundle\Service;


use AslakStudio\DocBundle\Annotation\Doc;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DocParser
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function parse($data)
    {
        foreach($data as $key => $single)
        {
            $data[$key] = $this->parseSingle($single);
        }
        return $data;
    }

    private function parseSingle($data)
    {
        foreach($this->getMethodKeyValue($data["annotation"]) as $key => $value)
        {
            $set = "set".ucfirst($key);
            if(method_exists($data["annotation"],$set))
                $data["annotation"]->$set($this->parseAttribute($key, $value,$data["method"]));
        }
        $data = $this->addPath($data);
        return $data["annotation"];
    }

    private function parseAttribute($name, $value, $method)
    {
        $func = 'set'.ucfirst($name);
        if(method_exists($this, $func))
        {
            return $this->$func($value, $method);
        }
        return $value;
    }

    private function setJson($value, $method)
    {
        return $this->container->get('doc.json')->extract($value,$method);
    }

    private function getMethodKeyValue($annotation)
    {
        $result = [];
        $methods = get_class_methods($annotation);
        foreach($methods as $val)
        {
            if(strstr($val,"get"))
            {
                $val_name = lcfirst(str_replace("get","",$val));
                $result = array_merge($result,[
                    $val_name => $annotation->$val()
                ]);
            }
        }
        return $result;
    }

    private function addPath($data)
    {
        $data["annotation"]->setPath($data["route"]->getPath());
        return $data;
    }
}