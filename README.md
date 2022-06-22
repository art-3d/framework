# Education, framework

## Purpose of the project
### > is to learn how frameworks work under the hood
### > walk from start to end of request -> response process
### > cover diferent parts of basic components

</br>

## todo:
- fix all features
- add unit tests
- add project description
- create migration
- add new features to framework (cache, logs, etc)
- use queue*
- refactor dependency injection by __construct

- add db relations (author, article)
- add comments
- fixtures
- explain structure of the project
- CSRF token for forms
- add pipeline for static analysis tool, disable push to master (PR only)
- use .env for config

<br/>

### xdebug config
```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/app": "${workspaceFolder}/app"
            }
        }
    ]
}

```