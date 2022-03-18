# Combination Lock
A combination lock CLI app with docker and phar build

## Business Rules

The cli app should display all possible codes for a combination lock with the following rules:

- The lock consists of a given number of rings (code length).
- Every ring has the numbers `0..9`
- The code does **not** contain the number `4`
- The code does contain at least one number `5`
- The code does contain at least one number `6`
- The code starts with an _odd number_ (`1`, `3`, `5`, `7`, `9`)
- The code sequence is equal or increasing with one exception: one number is allowed to be lower then the number before (for example `6-7-8-5-6` is allowed but `6-3-8-5-9` is **not** allowed).

## Design considerations

This app is build without any frameworks to keep it lightweight.

Although _composer autoloader_ is used for loading modules and _PHPUnit_ is used for tests.

The CLI App is inside the `index.php` file, which handles the console argument and also handles the `CombinationLock` App.

The main `CombinationLock` App consists of two main files, ie. `NumberCode` and `NumberCodeBuilder`.

`NumberCode` is a value object and holds the code, it can be only instantiated but not edited.

`NumberCodeBuilder` is a factory class that handles the creation of possible `NumberCode` objects by following the requirements (business rules).

It does so in two steps:

- First it uses a `SimpleCodeGenerator` to generate all possible code combinations for the given length and store them in a list of `NumberCode` objects.
- Then it passes that list of `NumberCode` objects to a _filter chain_. Each filter then applies one specific business rule on that list, returning a list with `NumberCode` objects that comply with the requirement.

The `Generator` and `Filters` are configured by the client `index.php` and injected into the `NumberCodeBuilder`.

### Why going that way

On the one hand, the classes are independent of each other, that means they can be easily tested or changed.

On the other hand, the system can be easily extended with new business rules by simply adding a new filter class.

> Of course all the rules could reside inside the builder, but that would make the system hard to test and to change.

### Possible improvements

The generator could be refactored to take the filter chain, so the filters could check the codes before creating `NumberCode` objects. That way, it would produce less objects that will be filtered out afterwards.

## Run the CLI App

The cli app is packaged in an executable phar archive.

To run the app, simply execute `php combinationlock.phar <n>` with n as the code length (at least 2).

Example:

```
$ php combinationlock.phar 5
10056
10156
.
.
.
99569
99956
```

## Development environment with Docker

#### Build image:

```
docker build -t php-cli-combilock .
```

This will pull and create a docker image with PHP8 and Composer 2.

It will also build the phar file (without dev dependencies like `phpunit`).

#### Run container

Without volume if you want to work inside docker:

```
docker run --name combilock -d php-cli-combilock
```

With a bind volume if you want to work on your host (so files will be updated):

```
docker run --name combilock -d -v $(pwd):/srv/app php-cli-combilock
```

> This option will override the phar file and some other files like vendor, so they will be gone until you install and build manually.

Check that container is up and running:

```
docker ps
```

The list should contain something like:

```
CONTAINER ID        IMAGE               COMMAND               CREATED             STATUS              PORTS               NAMES
a79d2aa8a484        php-cli-combilock   "tail -f /dev/null"   28 seconds ago      Up 28 seconds                           combilock
```

#### Start an interactive shell:

```
docker exec -it combilock sh
```

### Inside the docker container

When interactive shell is started, it's possible to run the following commands.

#### Build the phar file:

First make sure, that no dev-dependencies are installed (for security reasons), then build the phar file:
```
composer install --no-dev && composer clear-cache && composer dump-autoload
php build-phar.php
```

Execute the phar file:

```
php combinationlock.phar 5
```

#### Run unit tests:

```
vendor/bin/phpunit
```

### Cleanup docker setup

To remove the container:

```
docker stop combilock && docker rm combilock
```

To remove the image:

```
docker rmi php-cli-combilock
```
