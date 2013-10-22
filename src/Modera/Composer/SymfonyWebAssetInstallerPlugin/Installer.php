<?php

namespace Modera\Composer\SymfonyWebAssetInstallerPlugin;

use Composer\Composer;
use Composer\Installer\LibraryInstaller;
use Composer\IO\IOInterface;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

/**
 * @copyright 2013 Modera Foundation
 * @author Sergei Lissovski <sergei.lissovski@modera.org>
 */
class Installer extends LibraryInstaller
{
    private function validateSymfonyPackagePresence(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        foreach ($repo->getPackages() as $installedPackage) {
            /* @var PackageInterface $installedPackage */
            if ($installedPackage->getName() == 'symfony/symfony') {
                return;
            }
        }

        throw new \RuntimeException(sprintf(
            "Package '%s' cannot be installed to this project because the project doesn't have 'symfony/symfony' package installed.",
            $package->getName()
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        $this->validateSymfonyPackagePresence($repo, $package);

        parent::install($repo, $package);
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
        return 'web/' . $package->getPrettyName();
    }
}