# Neo Web Service Example

## Getting Started

### Technologies used

* [PhpStorm](https://www.jetbrains.com/phpstorm/) - The IDE
* [Symfony](https://symfony.com/doc/2.8/setup.html) - The Framework

Symfony Components

* [GuzzleBundle](https://github.com/8p/GuzzleBundle) - Integrates PHP HTTP Client, into Symfony 2/3
* [JMSSerializerBundle](http://jmsyst.com/bundles/JMSSerializerBundle) - Allows you to serialize your data into a requested output format
* [Mongo PHP Adapter](https://github.com/alcaeus/mongo-php-adapter) - Provides ext-mongo interface on top of mongo-php-library
* [Doctrine MongoDB ODM](https://github.com/doctrine/mongodb-odm) - Doctrine MongoDB Object Document Mapper
* [DoctrineMongoDBBundle](http://symfony.com/doc/master/bundles/DoctrineMongoDBBundle/index.html) 

### Prerequisites

* Composer 
* Apache( or Nginx)
* MongoDB

### Installing

At first you need to set up parameters.yml.

``` yml
parameters:
    neo_ws:
        end_point: 'https://api.nasa.gov/neo/rest/v1'
        api_key: N7LkblDsc5aen05FJqBQ8wU4qSdmsftwJagVK7UD
    mongodb_server: mongodb://localhost:27017
    mongodb_database: neo_ws
```

Then you can run following command to install dependencies ```composer install```.

## Running

First command must be ran to get feeds in last 3 days: `php app/console neo:ws:feed`.

Now you can start the server and view contents in browser: `php app/console server:start`.

Below you may find route list.

| Method  | Path                         | Params                        |
| ------  | ---------------------------  | ----------------------------- |
| GET     | [/](http://127.0.0.1:8000/)                              |                               |
| GET     | [/neo/hazardous](http://127.0.0.1:8000/neo/hazardous)                              |                               |
| GET     | [/neo/fastest](http://127.0.0.1:8000/neo/fastest)                               | hazardous(required: false): boolean |
| GET     | [/neo/slowest](http://127.0.0.1:8000/neo/slowest)                                | hazardous(required: false): boolean |

## Stop

Following will line stop the server `php app/console server:stop`.

## Authors

* **Emrah Sifoğlu** - *Initial work* - [emrahsifoglu](https://github.com/emrahsifoglu)

## License

This project is a task thus source is kept in a private repo.

Resources
========

- http://symfony.com/doc/2.8/setup.html
- https://stackoverflow.com/questions/39753772/how-to-get-the-query-parameters-in-a-guzzle-psr7-request
- https://stackoverflow.com/questions/23372598/adding-query-string-params-to-a-guzzle-get-request
- https://stackoverflow.com/questions/17488207/convert-a-string-to-json-object-php
- http://docs.doctrine-project.org/projects/doctrine-mongodb-odm/en/latest/reference/introduction.html#using-php-7
- https://stackoverflow.com/questions/10978242/mongodb-odm-select-count-equivalent
- https://knpuniversity.com/blog/fun-with-symfonys-console
- https://knpuniversity.com/screencast/new-in-symfony3/console-styling
