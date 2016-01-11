```yml
assetic:
    debug:          "%kernel.debug%"
    use_controller: true
    filters:
        cssrewrite: ~
```

```yml
doc:
    resource: "@AslakStudioDocBundle/Resources/config/routing.yml"
    prefix:   /doc
```

```yml
aslak_studio_doc:
    name: My App
```

### Add

```php
	new Symfony\Bundle\AsseticBundle\AsseticBundle(),
	new AslakStudio\DocBundle\AslakStudioDocBundle(),
```

### Composer

```json
    "repositories" : [{
        "type" : "vcs",
        "url" : "https://github.com/PasturelP/AslakDocBundle.git    "
    }]
```

```json
"aslak/doc-bundle": "dev-master"
```


### Use

```php

<?php

use AslakStudio\DocBundle\Annotation\Doc;

class MyController extends Controller
{
    /**
     *
     * @Doc(
     *  description="My Method Description",
     *  method={"POST", "GET"},
     *  parameters={
     *      {"name"="id", "type"="integer", "required"=false, "description"="Parameter ID"}
     *  },
     *  tags={"doc", "documentation", "tag"}
     * )
     *
     * @Route("/", name="my_route")
     */


```