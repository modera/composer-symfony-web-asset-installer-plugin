<?php

namespace Modera\Composer\SymfonyWebAssetInstallerPlugin;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

/**
 * @copyright 2013 Modera Foundation
 * @author    Sergei Lissovski <sergei.lissovski@modera.org>
 */
class Installer extends LibraryInstaller
{
    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'symfony-web-asset' == $packageType;
    }

    /**
     * @inheritDoc
     */
    public function getInstallPath(PackageInterface $package)
    {
        $extra = $package->getExtra();

        // a package being installed has ability to specify a custom location where its contents
        // should be installed, this feature should be used with great care because chances are
        // it might override existing files
        $targetPath = isset($extra['target_dir']) && strlen($extra['target_dir']) ? $extra['target_dir'] : '';
        $targetPath = 'web/' . ($targetPath ? $targetPath . '/' : '');

        if ($targetPath && !file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $packagePath = $package->getPrettyName();
        if (isset($extra['package_dir']) && strlen($extra['package_dir'])) {
            $packagePath = $extra['package_dir'];
        }

        return  $targetPath . $packagePath;
    }
}