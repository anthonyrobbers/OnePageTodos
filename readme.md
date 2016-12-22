#getting started with laradockTodos

instalation:

1. install vagrant (directly since there are version issues if it is installed indirectly by another https://www.vagrantup.com/docs/getting-started/  )


2. instal docker (  https://www.docker.com/products/overview   )


3. pull this repository (for windows to a directory in your user folder)




operation:
0. start virtual machine if it is needed using docker quickstart terminal (and note the ip of said virtual machine)


1. cd to this repository (in virtual machine terminal)


2. cd to laradock (in virtual machine terminal)


3. docker-compose up -d  nginx mysql


4. docker exec -it laradock_workspace_1 php artisan migrate  (use kitematic to quickly find the name if it is not laradock_workspace_1)


5. visit the ip address assigned to laradock (the noted ip from above)


# Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).