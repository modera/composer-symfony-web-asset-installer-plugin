# ModeraComposerSymfonyWebAssetInstallerPlugin

The plugin allows to install package which have their type set to "symfony-web-asset" to a custom location. 

## Installation

This plugin can be installed by running this command:

    composer require modera/composer-symfony-web-asset-installer-plugin:~1.0

## Documentation

Your package needs to have its type set to "symfony-web-asset" in order for this plugin to install it to `web` directory,
also by optionally specifying `target_dir` in your package's extra you can change a directory where its contents will
be extracted to. This is how a sample package could look like:

    {
        "type": "symfony-web-asset",
        "name": "acme/foo-bar",
        "extra": {
            "target_dir": "hello"
        }
    }

With this extra configuration package will be installed to `web/hello/acme/foo-bar`.

## Licensing

This plugin is under the MIT license. See the complete license in the file:
LICENSE