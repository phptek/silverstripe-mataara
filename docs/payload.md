# Payload

See https://mataara.readthedocs.io/en/latest/development/report_format.html for the JSON spec

## Payload Breakdown

* `Databases`: Populate from `ENV` vars or `.env`
* `ServerHostname`: Populated from `$_SERVER['HTTP_HOST']` or `<?php exec('hostname');`
* `DrupalVersion`: (See suggestion for `Versions` key below) Use composer.lock info via Composer lib. OR can we stuff the current tag into the "DrupalVersion" key ala

```
"DrupalVersion": "4.11.6 / 2.2.1" // <Core> / <Tag> / PHP
```

* `Environment` Consume `SS_ENVIRONMENT_TYPE` ENV var
* `ReportGenerated` `<?php time();`
* `ServerName` Populated from `<?php exec('hostinfo');`
* `ReportExpiry` ??
* `SiteRoot` `<?php echo __DIR__;`
* `SiteSlogan` N/A
* `Nodes` (See TODO below)
* `DirectoryHash` <?php echo md5(BASE_PATH); `
* `Themes` An array of data as follows 

```
[
    json_encode([
        'Version' => 'N/A',
        'Theme' => ThemeList::getThemes(), // Something like this
        'Url' => 'N/A',
        'Description' => 'N/A',
        'Name' => ThemeList::getThemes(), // Something like this
        'Project' => 'N/A',
    ]),
    ...
]
```

* `AdminRole` An array of data taken from the "administrators" `Group` record
* `Packages` An array of data as follows

```
[
    json_encode([
        'Package' => 'phptek/silverstripe-mataara',
        'Description' => 'https://github.com/phptek/siverstripe-mataara/master/blob/README.md',
        'Url' => 'https://github.com/phptek/silverstripe-mataara.git',
        'Version' => // Get data from Composer package,
        'Name' => 'phptek/silverstripe-mataara',
        'Module' => 'N/A',
        'Project' => 'N/A',
    ]),
    ...
]
```

* `SiteTtitle` Could be taken from `composer.json`'s "description" field if present or a formatted version of the gitlab project name
* `SiteKey` Just use `hash('sha256', <some_unique_data_about_the_site>);`
* `Users` `Member::get()->count()`
* `ReportType` `sprintf('silverstripe/%s', Composer::version('silverstripe/framework')); ` // Something like that

# TODO

* [DONE] Submit issue(s) to Mataara:
** [DONE] [Remove unecessary requirement for "Drupal" prefix in JSON payload keys](https://gitlab.com/mataara/Mataara-Server/-/issues/31)
** [Remove unecessary "Drupal" prefix in Dashboard view text/copy](https://gitlab.com/mataara/Mataara-Server/-/issues/31)
** [DONE] Add/Modify fields to JSON Payload:
*** [DONE] [`Nodes` as in Drupal nodes? Let's lose this in favour of "Pages" or "URIs"](https://gitlab.com/mataara/Mataara-Server/-/issues/31)
*** [DONE] [See here](https://gitlab.com/mataara/Mataara-Server/-/issues/33) `VCSHost`
*** [DONE] [See here](https://gitlab.com/mataara/Mataara-Server/-/issues/32) `Versions`

```
{
    "Core": 1.2.3,
    "PHP": 8.1,
    "App": <tag_branch_or_commit>
}
```
*** 

