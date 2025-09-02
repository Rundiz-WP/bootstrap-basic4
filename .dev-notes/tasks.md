# Tasks

Describe what to do in each task, step by step.

## First start.
This is only run for the first time after cloning the repository from GitHub.

* Make sure that you had ever run `npm install` by check at folder **node_modules** must be exists.

### Manual update version number.
* Update Bootstrap version at **inc/classes/BootstrapBasic4.php** inside `enqueueScriptsAndStyles()`, and `registerCommonScriptsAndStyles()` methods.
* Update FontAwesome version at **inc/classes/BootstrapBasic4.php** inside `enqueueScriptsAndStyles()` method.

## Before publish or commit.
* Update theme version number at **style.css**.
* Update theme version at **inc/classes/BootstrapBasic4.php** inside `enqueueScriptsAndStyles()` method.
* Update **changelog.md**