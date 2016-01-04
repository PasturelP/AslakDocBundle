```yml
	assetic:
		debug:          "%kernel.debug%"
		use_controller: false
		bundles:        [ ]
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