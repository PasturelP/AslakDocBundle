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