#getting started with laradockTodos

instalation:

1. install vagrant (directly since there are version issues if it is installed indirectly by another https://www.vagrantup.com/docs/getting-started/  )


2. instal docker (  https://www.docker.com/products/overview   )


3. pull this repository (for windows to a directory in your user folder)




operation (docker):
0. start virtual machine if it is needed using docker quickstart terminal (and note the ip of said virtual machine)


1. cd to this repository (in virtual machine terminal)


2. cd to laradock (in virtual machine terminal)


3. docker-compose up -d  nginx mysql


4. docker exec -it laradock_workspace_1 php artisan migrate  (use kitematic to quickly find the name if it is not laradock_workspace_1)


5. visit the ip address assigned to laradock (the noted ip from above)


