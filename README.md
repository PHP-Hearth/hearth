Hearth
======

[![Build Status](http://jenkins.maxvandervelde.com/view/Hearth/job/Hearth%20Bugfix%20Release%20Updater/badge/icon)](http://jenkins.maxvandervelde.com/view/Hearth/job/Hearth%20Bugfix%20Release%20Updater/)

Hearth is a PHP command line build tool for PHP projects. It is built with
defined tasks and targets expressed in PHP code. You can easily extend it to
create your own targets and tasks.

*Keep your PHP projects warm by the fire with Hearth.*

## Installation (\*nix)

### 1. Download

You can download Hearth from Github. It is suggested to download the files to
a bin directory (like `/usr/local/bin/` or `~/bin/`):

    $ git clone git://github.com/PHP-Hearth/hearth.git

### 2. Run Composer Install

You must run Composer to download the dependencies for Hearth. See
[Documentation on Composer](http://getcomposer.org/doc/00-intro.md#installation-nix) for more
information about downloading and installing composer.

    $ cd hearth
    $ composer.phar install

### 3. Symlink hearth Into Path

    $ ln -s /path/to/hearth/Hearth/hearth.php ~/bin/hearth

## Usage

Basic usage of Hearth involves running the `hearth` command on the command line
from your project's root directory.

Without any arguments, Hearth will display the available targets and tasks.

    $ hearth
    Hearth Build: /var/www/example-project/.hearth.yml
    Available Targets
    -----------------
        - Hearth/DemoTarget

You can run a specific target by providing the name of the target (including
the namespace):

    $ hearth Hearth/DemoTarget
    Hearth Build: /var/www/example-project/.hearth.yml
    Hello World

    Build Successful!
    Build execution time: 0.004896s

This example target is merely a hello world for demonstration purposes.

### The `.hearth.yml` Config File

Hearth looks for a `.hearth.yml` file in the root directory of your project.
In this config file (YAML format) you can define the targets and tasks that
should be run during a build.

    namespace:
    targets:
    tasks:
    children:
      Hearth: Hearth/.hearth.yml
