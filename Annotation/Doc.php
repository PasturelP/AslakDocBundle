<?php

namespace AslakStudio\DocBundle\Annotation;

use Symfony\Component\Routing\Route;

/**
 * @Annotation
 */
class Doc
{
    private $resource;

    private $description;

    private $method = [];

    private $parameters = [];

    private $json;

    private $tags = [];

    private $path;

    public function __construct($data)
    {
        $this->resource = !empty($data['resource']) ? $data['resource'] : false;
        foreach ($data as $k => $d) {
            if($k == "parameters")
            {
                foreach($d as $keyParam => $valParam)
                {
                    array_push($this->$k,new DocParameter($valParam));
                }
            }else
            {
              $this->$k = $d;
            }

        }

    }


    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return Boolean
     */
    public function isResource()
    {
        return (bool)$this->resource;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @param mixed $json
     */
    public function setJson($json)
    {
        $this->json = $json;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}












