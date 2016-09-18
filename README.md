phpBB 3.1 Extension - Prune Users
=====================

[![Build Status](https://travis-ci.org/kasimi/phpbb-ext-pruneusers.svg?branch=master)](https://travis-ci.org/kasimi/phpbb-ext-pruneusers)

This extension periodically deletes user accounts simply based on their date of registration. The extension adds a new option in `ACP -> General -> Board features` that allows you to configure the amount of time after which a user account is deleted. The cron task runs once every hour.

## Requirements
* phpBB 3.1.0-b1 or higher
* PHP 5.3.3 or higher

## Installation
You can install this extension by following these steps:

1. Copy the files `ext/kasimi/pruneusers`. Make sure the file `ext/kasimi/pruneusers/composer.json` is present.
2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
3. Next to `Prune Users` click on `Enable`.

## Update
You can update the extension to a newer version by following these steps:

1. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click on `Disable` next to `Prune Users`.
2. Delete the contents of the folder `ext/kasimi/pruneusers`.
3. Copy the contents of the new version to `ext/kasimi/pruneusers`.
4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click on `Enable` next to `Prune Users`.

## Uninstallation
1. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click on `Disable` next to `Prune Users`.
2. To permanently uninstall the extension, click on `Delete Data`. You can then safely delete the `ext/kasimi/pruneusers` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)

© 2016 kasimi
