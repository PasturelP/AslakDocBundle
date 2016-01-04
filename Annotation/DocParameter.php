<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 16/12/15
 * Time: 17:31
 */

namespace AslakStudio\DocBundle\Annotation;


class DocParameter
{
    private $name;

    private $type;

    private $description;

    private $required;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param mixed $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }

    public function __construct($data)
    {
        foreach($data as $k => $d)
            $this->$k = $d;
    }

}