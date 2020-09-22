# Sami PHPCI Plugin

Sami PHPCI Plugin gives the possibility to generate a documentation with [Sami](https://github.com/FriendsOfPHP/Sami) in [PHPCI](https://www.phptesting.org/).

⚠️ This project is no longer maintained. ⚠️

## Installation

This plugin can be installed via [composer](https://getcomposer.org/):

```bash
composer require mauchede/sami-phpci-plugin
```

## Usage

This plugin takes the following options:
* `config` (string, optional): Allows you to pass the [Sami configuration file](https://github.com/FriendsOfPHP/Sami#configuration). The default value is `./sami.php`.
* `force` (boolean, optional): Allows you to force (or not) to rebuild from scratch. The default value is `true`.

An example of `phpci.yml` with this plugin:

```yml
complete:
    \Mauchede\PHPCI\Plugin\Sami:
        config: sami.config.file
        force: false
```

## Links

* [composer](https://getcomposer.org/)
* [phpci](https://www.phptesting.org/)
* [sami](https://github.com/FriendsOfPHP/Sami)
* [sami configuration file](https://github.com/FriendsOfPHP/Sami#configuration)
