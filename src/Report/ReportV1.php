<?php

namespace PhpTek\Mataara\Client;

use PhpTek\Mataara\Report\AbstractReport;
use SilverStripe\Security\Member;

/**
 * Allows factories to build a report to suit the original Mataara (Drupal centric)
 * report format.
 * 
 * @author Russell Michell <russ@theruss.com>
 * @package phptek/silverstripe-mataara
 */
 class MataaraReport extends AbstractReport
 {
    /**
     * @return array
     */
    public function getDatabases(): array
    {
        return [
            // Just bake-in "default". We'll accept PRs for those wanting to use
            // multiple databases using point-cutting etc
            'default' => [
                'default' => [
                    'Host' => null,
                    'Database' => null,
                    'Driver' => null,
                ]
            ],
        ];
    }

    /**
     * @return string
     */
    public function getServerHostname(): string
    {
        return '';
    }

    /**
     * Return version of `silverstripe/framework` in-use from Composer.
     * 
     * @return string
     */
    public function getDrupalVersion(): string
    {
        return '';
    }

    /**
     * @return array
     */
    public function getEnvironment(): array
    {
        return [
            'Name' => null,
            'Label' => null,
        ];
    }

    /**
     * Report generated date.
     * 
     * @return string
     */
    public function getReportGenerated(): string
    {
        return '';
    }

    /**
     * Return the hostname as per exec('hostname')
     * 
     * @return string
     */
    public function getServerName(): string
    {
        return '';
    }

    /**
     * Report expiry date. Maybe predicate this on: now() > (generated-date + config interval)?
     * 
     * @return string
     */
    public function getReportExpiry(): string
    {
        return '';
    }

    /**
     * Return the value of PUBLIC_PATH
     * 
     * @return string
     */
    public function getSiteRoot(): string
    {
        return '';
    }

    /**
     * @return boolean
     */
    public function getSiteSlogan(): bool
    {
        return false;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'Revisions' => null,
            'Nodes' => null,
        ];
    }

    /**
     * Return an MD5 hash of everything under the "app" and "themes" dir.
     * 
     * @return string
     */
    public function getDirectoryHash(): string
    {
        return '';
    }

    /**
     * Return an array of all themes under the "themes" dir, containing the keys found
     * at: https://mataara.readthedocs.io/en/latest/development/report_format.html
     * 
     * @return array
     */
    public function getThemes(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getAdminRole(): array
    {
        return [
            'RoleName' => null,
            'RoleID' => null,
            'RoleUsers' => [
                'uid' => [
                    'Name' => null,
                    'Mail' => null,
                    'Status' => null,
                    'LastLogin' => null,
                ]
            ],
        ];
    }

    /**
     * Return an array of all installed (non-dev) modules under the "vendor" dir, containing the keys found
     * at: https://mataara.readthedocs.io/en/latest/development/report_format.html. Note: Use Composer's API
     * for this, not globbing the contents of the "vendors" dir, as not every lib/module is a Composer "vendormodule"
     * 
     * @return array
     */
    public function getModules(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getSiteTitle(): string
    {
        return '';
    }

    /**
     * Returns the value of Client::config()->get('public_key')
     * 
     * @return string
     */
    public function getSiteKey(): string
    {
        return '';
    }

    /**
     * A count of all this site's users.
     * 
     * @return string
     */
    public function getUsers(): int
    {
        return Member::get()->count();
    }

    /**
     * ReportType is used by Mataara to know how to parse incoming reports.
     * 
     * @return string
     */
    public function getReportType(): string
    {
        return 'silverstripe-mataara';
    }






 }