# **ONE CLICK SOLAR** #

##############################
# PHP ENVIRONMENT EXECUTABLE #
##############################

### For MediaTemple use "php-latest"

```
#!bash

PHP='php-latest'
```

### Otherwise use "php"

```
#!bash

PHP='php'
```


###########
# INSTALL #
###########

# 1. Install Composer Binary

```
curl -sS https://getcomposer.org/installer | $PHP -d allow_url_fopen=On
```


# 2. Require Asset-Plugin

```
$PHP composer.phar global require "fxp/composer-asset-plugin:~1.2.0"
```


# 3. Create Initial Autoloader Classes and Install Packages

```
$PHP composer.phar -vvv update
```


# 4. Yii Framework Migration
```
$PHP yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
$PHP yii migrate --migrationPath=@yii/rbac/migrations
```

# 5. Post/Final Composer Update

```
$PHP composer.phar -vvv update
```
