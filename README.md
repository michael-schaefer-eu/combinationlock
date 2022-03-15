# Combination Lock
A combination lock CLI app with docker and phar build

## Docker

Build image:

`docker build -t php-cli-combilock .`

Run container:

`docker run --name combilock -d php-cli-combilock`

Run container with bind volume (for development):

`docker run --name combilock -d -v $(pwd):/srv/app php-cli-combilock`

Check that container is running (up):

`docker ps`

The list should contain something like:

```
CONTAINER ID        IMAGE               COMMAND               CREATED             STATUS              PORTS               NAMES
a79d2aa8a484        php-cli-combilock   "tail -f /dev/null"   28 seconds ago      Up 28 seconds                           combilock
```

Start an interactive shell:

`docker exec -it combilock sh`

### Inside the docker container

When interactive shell is started, it's possible to run the following commands.

Build the phar file:

`php build-phar.php`

Execute the phar file (with _count_ parameter, ie. 5):

`php combinationlock.phar 5`

Run the unit tests:

`vendor/bin/phpunit`

### Cleanup docker setup

To remove the container:

`docker stop combilock && docker rm combilock`

To remove the image:

`docker rmi php-cli-combilock`
