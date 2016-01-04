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
    name: Alex Click
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
        "url" : "https://PasturelP@bitbucket.org/AslakStudio/docbundle.git"
    }]
```

```json
"aslak/doc-bundle": "dev-master"
```