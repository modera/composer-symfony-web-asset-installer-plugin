<?php

namespace Modera\Composer\SymfonyWebAssetInstallerPlugin;

use Composer\Plugin\PluginInterface;
use Composer\Composer;
use Composer\IO\IOInterface;

/**
 * @copyright 2013 Modera Foundation
 * @author Sergei Lissovski <sergei.lissovski@modera.org>
 */
class Plugin implements PluginInterface
{
    /**
     * @inheritDoc
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $composer->getInstallationManager()->addInstaller(new Installer($io, $composer));
    }
}