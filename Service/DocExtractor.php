<?php
/**
 * Created by PhpStorm.
 * User: paul
 * Date: 16/12/15
 * Time: 16:43
 */

namespace AslakStudio\DocBundle\Service;


use AslakStudio\DocBundle\Annotation\Doc;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;


class DocExtractor
{
    const ANNOTATION_CLASS = 'AslakStudio\\DocBundle\\Annotation\\Doc';

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var ControllerNameParser
     */
    protected $controllerNameParser;

    public function __construct(ContainerInterface $container, RouterInterface $router, Reader $reader, ControllerNameParser $controllerNameParser)
    {
        $this->container            = $container;
        $this->router               = $router;
        $this->reader               = $reader;
        $this->controllerNameParser = $controllerNameParser;
    }

    public function extract()
    {
        $array = [];
        foreach ($this->getRoutes() as $route) {
            if (!$route instanceof Route) {
                throw new \InvalidArgumentException(sprintf('All elements of $routes must be instances of Route. "%s" given', gettype($route)));
            }

            if ($method = $this->getReflectionMethod($route->getDefault('_controller'))) {
                $annotation = $this->reader->getMethodAnnotation($method, self::ANNOTATION_CLASS);
                if($annotation)
                {
                    if ($annotation->isResource()) {
                        if ($resource = $annotation->getResource()) {
                            $resources[] = $resource;
                        } else {
                            // remove format from routes used for resource grouping
                            $resources[] = str_replace('.{_format}', '', $route->getPath());
                        }
                    }
                    array_push($array,[
                        'annotation' => $annotation,
                        'method' => $method,
                        'route' => $route
                    ]);
                }
            }
        }
        return $array;
    }

    public function getRoutes()
    {
        return $this->router->getRouteCollection()->all();
    }

    public function getReflectionMethod($controller)
    {
        if (false === strpos($controller, '::') && 2 === substr_count($controller, ':')) {
            $controller = $this->controllerNameParser->parse($controller);
        }

        if (preg_match('#(.+)::([\w]+)#', $controller, $matches)) {
            $class = $matches[1];
            $method = $matches[2];
        } else {
            if (preg_match('#(.+):([\w]+)#', $controller, $matches)) {
                $controller = $matches[1];
                $method = $matches[2];
            }

            if ($this->container->has($controller)) {
                // BC SF < 3.0
                if (method_exists($this->container, 'enterScope')) {
                    $this->container->enterScope('request');
                    $this->container->set('request', new Request(), 'request');
                }
                $class = ClassUtils::getRealClass(get_class($this->container->get($controller)));
                // BC SF < 3.0
                if (method_exists($this->container, 'enterScope')) {
                    $this->container->leaveScope('request');
                }

                if (!isset($method) && method_exists($class, '__invoke')) {
                    $method = '__invoke';
                }
            }
        }

        if (isset($class) && isset($method)) {
            try {
                return new \ReflectionMethod($class, $method);
            } catch (\ReflectionException $e) {
            }
        }

        return null;
    }

}