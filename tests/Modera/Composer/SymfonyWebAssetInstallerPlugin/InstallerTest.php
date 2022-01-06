<?php

namespace Modera\Composer\SymfonyWebAssetInstallerPlugin;

use Composer\Composer;
use Composer\Config;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;

/**
 * @author    Sergei Lissovski <sergei.lissovski@modera.org>
 * @copyright 2016 Modera Foundation
 */
class InstallerTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Installer
     */
    private $installer;

    public function setUp()
    {
        $config = \Phake::mock(Config::class);

        $composer = \Phake::mock(Composer::class);
        \Phake::when($composer)
            ->getConfig()
            ->thenReturn($config)
        ;

        $this->installer = new Installer(\Phake::mock(IOInterface::class), $composer);
    }

    public function testSupports()
    {
        $this->assertTrue($this->installer->supports('symfony-web-asset'));
        $this->assertFalse($this->installer->supports('library'));
        $this->assertFalse($this->installer->supports('project'));
    }

    public function testGetInstallPath()
    {
        // PLUGIN_HOME constant is defined at /Test/bootstrap.php

        $package1 = $this->createDummyPackage('foopkg');

        // no extra available, should be installed to
        $dir = $this->installer->getInstallPath($package1);
        $this->assertEquals('public/foopkg', $dir);
        $this->assertFileExists(PLUGIN_HOME . '/public');

        rmdir(PLUGIN_HOME . '/public');
    }

    public function testGetInstallPath_withExtra()
    {
        $package1 = $this->createDummyPackage('barpkg', array('target_dir' => 'yoyo', 'package_dir' => 'spin'));

        $dir = $this->installer->getInstallPath($package1);
        $this->assertEquals('public/yoyo/spin', $dir);
        $this->assertFileExists(PLUGIN_HOME . '/public/yoyo');

        rmdir(PLUGIN_HOME . '/public/yoyo');
        rmdir(PLUGIN_HOME . '/public');
    }

    private function createDummyPackage($prettyName, $extra = array())
    {
        $package = \Phake::mock(PackageInterface::class);
        \Phake::when($package)
            ->getExtra()
            ->thenReturn($extra)
        ;
        \Phake::when($package)
            ->getPrettyName()
            ->thenReturn($prettyName)
        ;

        return $package;
    }
}
