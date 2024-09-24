# Education, framework

## Purpose of the project
### > is to learn how frameworks work under the hood
### > walk from start to end of request -> response process
### > cover diferent parts of basic components

</br>

## todo:
- fix all features [x]
- add unit tests
- add project description
- create a migration command [x]
- use the migration command on setup
- add new features to framework (cache, logs, etc)
- use queue*
- refactor dependency injection by __construct

- add db relations (author, article)
- add comments
- fixtures
- explain structure of the project
- CSRF token for forms
- add pipeline for static analysis tool, disable push to master (PR only) (CI/CD)
- use .env for config
- EventDispatcher
- handle 404, 5xx error
- add logger
- add pagination
- fix psalm warnings

<br/>

### [Xdebug]
#### Find host:
```
$ ipconfig getifaddr en0 #mac
$ hostname -I | cut -d ' ' -f1 #linux
```

#### Config:
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