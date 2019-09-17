# Tasks

Describe what to do in each task, step by step.

## First start.
This is only run for the first time after cloning the repository from GitHub.

* Make sure that you had ever run `npm install` by check at folder **node_modules** must be exists.

### Before start development.
This should be run every time before start modify the theme files.

* Manually delete **.backup** folder.

## Update packages (Bootstrap, FontAwesome).
* Run the command `npm outdated` for listing outdated packages.
* Run the command `npm update` to update packages.
* Run the command `npm run build` to copy those packages to **assets** folder.

### Manual update version number.
You can use package management to run write packages version automatically but to do it manually, please update the version number on these files.

* Update Bootstrap version at **inc/classes/BootstrapBasic4.php** inside `enqueueScriptsAndStyles()`, and `registerCommonScriptsAndStyles()` methods.
* Update FontAwesome version at **inc/classes/BootstrapBasic4.php** inside `enqueueScriptsAndStyles()` method.
* Update theme version at **style.css** at file header.
* Update theme version at **inc/classes/BootstrapBasic4.php** inside `enqueueScriptsAndStyles()` method.

## Editing files.
If you are editing theme files such as PHP, JS, CSS, etc. and your target folder is different from editing folder.<br>
For example: You are editing theme at **C:\github\bootstrap-basic4** and your running WordPress for theme development is at **C:\wwwroot\wordpress**.<br>
You can run the following command to make it watch your changed files and copy automatically.

The `--target` option must follow with path but no trailing slash or backslash.

* Run the command `gulp editing --target "C:\wwwroot\wordpress" --copy-all` to cleanup target folder, start copy all files, then watch only changed files.
* Run the command `gulp editing --target "C:\wwwroot\wordpress"` to watch only changed files.

## Before publish or commit.
* Update theme version number at **style.css**.
* Run the command `npm run writeVersions` to write the packages version and theme version into **inc/classes/BootstrapBasic4.php** file.
* Open files in **inc/classes/BootstrapBasic4.php**, **.backup/inc/classes/BootstrapBasic4.xxx.php** where xxx is the date/time of running command.<br>
    Then compare these 2 files to make sure that only version number just changed, otherwise incorrect PHP syntax may cause the website error.
* Update **changelog.md**