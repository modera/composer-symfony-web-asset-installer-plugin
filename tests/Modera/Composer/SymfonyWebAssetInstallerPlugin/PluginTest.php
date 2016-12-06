<?php

namespace Modera\Composer\SymfonyWebAssetInstallerPlugin;

use Composer\Composer;
use Composer\Config;
use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;

/**
 * @author    Sergei Lissovski <sergei.lissovski@modera.org>
 * @copyright 2016 Modera Foundation
 */
class PluginTest extends \PHPUnit_Framework_TestCase
{
    public function testActivate()
    {
        $plugin = new Plugin();

        $config = \Phake::mock(Config::class);

        $composer = \Phake::mock(Composer::class);
        \Phake::when($composer)
            ->getConfig()
            ->thenReturn($config)
        ;

        $io = \Phake::mock(IOInterface::class);

        $installMgr = \Phake::mock(InstallationManager::class);
        \Phake::when($composer)
            ->getInstallationManager()
            ->thenReturn($installMgr)
        ;

        $plugin->activate($composer, $io);

        /* @var Installer $createdInstaller */
        $createdInstaller = null;

        \Phake::verify($installMgr)
            ->addInstaller(\Phake::capture($createdInstaller))
        ;

        $this->assertInstanceOf(Installer::class, $createdInstaller);
    }
}