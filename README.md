# Silverstripe Mataara

This module allows your Silverstripe applicaton to push data about the app/site into a [Mataara](https://mataara.readthedocs.io/) instance. It's a bit like [Sentry](https://sentry.io) in this respect: Anonymously and securely push certain application-specific data to a centralised server to which only authorised users are permitted access to view.

Mataara's intended use-case is around displaying core and module CVE's at-a-glance alongside some other, seemingly arbitrary environment information. Mataara appears to be very Drupal centric, but several new issues have been raised recently in its issue-tracker to address this.

# Install

```
#> composer require phptek/silverstripe-mataara
#> ./vendor/bin/sake dev/build
```

# Setup


## YML Config

Add a YML config file to your project's `_config` directory named `mataara.yml` (or to any other YML file you like):

```
PhpTek\Mataara\Client\Client:
  config:
    host: 'my-mataara-instance.com'
```

## QueuedJobs

Ensure you setup the `symbiote/silverstripe-queuedjobs` module as per [its instructions](https://github.com/symbiote/silverstripe-queuedjobs). If hosting on a multi-server cloud environment such as Azure App Services, AWS Fargate or K8s, you'll likely want to setup a dedicated container just for the cron.

# TODO

* Ascertain that the JSON payload [documented here](https://mataara.readthedocs.io/en/latest/development/report_format.html) is still valid
* Ascertain if generating and sending the JSON is all that's required
* Ascertain if Mataara can generate or send alerts (Email, Slack, RSS). If not, submit an issue to add it

# See Also

* [`phptek/silverstripe-sentry`](https://github.com/phptek/silverstripe-sentry) Silverstripe Sentry module (Maintained by Russ Michell)
* [Mataara Issue Tracker](https://gitlab.com/mataara/Mataara-Server/-/issues/)
