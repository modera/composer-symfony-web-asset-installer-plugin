<?php

namespace Modera\Composer\SymfonyWebAssetInstallerPlugin;

use Composer\Composer;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

/**
 * @copyright 2013 Modera Foundation
 * @author    Sergei Lissovski <sergei.lissovski@modera.org>
 */
class Installer extends LibraryInstaller
{
    private function isSymfonyPackagePresent(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        foreach ($repo->getPackages() as $installedPackage) {
            /* @var PackageInterface $installedPackage */
            if ($installedPackage->getName() == 'symfony/symfony') {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        if ($this->isSymfonyPackagePresent($repo, $package)) {
            parent::install($repo, $package);
        }
    }

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
    protected function getPackageBasePath(PackageInterface $package)
    {
        $extra = $package->getExtra();

        $targetPath = isset($extra['target_dir']) && strlen($extra['target_dir']) ? $extra['target_dir'] : '';
        $targetPath = 'web/' . ($targetPath ? $targetPath . '/' : '');

        if ($targetPath && !file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        return  $targetPath . $package->getPrettyName();
    }
}