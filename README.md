# Silverstripe Mataara

**NOTICE** August 2022 - this project is a WIP and therefore _incomplete_. Use/Modify at your own risk!

This module allows your Silverstripe applicaton to push data about the app/site into a [Mataara](https://mataara.readthedocs.io/) instance. It's a bit like [Sentry](https://sentry.io) in this respect: Anonymously and securely push certain application-specific data to a centralised server to which only authorised users are permitted access to view.

Mataara's intended use-case is around displaying core and module CVE's at-a-glance alongside some other, seemingly arbitrary environment information. Mataara appears to be very Drupal centric, but several new issues have been raised recently in its issue-tracker to address this.

# Requirements

* PHP7+
* `silverstripe/framework ^4`
* A public key given to you by your Mataara administrator

# Install

```
#> composer require phptek/silverstripe-mataara
#> ./vendor/bin/sake dev/build
```

# Setup

There is no need to configure something like this using Silverstripe's UI. Just set and forget in YML config and environment variables. This way we can be reasonably assured that what we told the app to send to Mataara at time of a release, will continue to be sent in a predictable manner and frequency.

1. Add a YML file to your project's `_config` directory of the following format:

```
PhpTek\Mataara\Client\Client:
  opts:
    # Transport Mode: Reserved for future compatibility
    mode: http
    # The hostname or email of your Mataara instance ("http" mode requires Mataara to be reachable on an SSL-aware host)
    address: 'my-mataara-instance.com'
    # Public key set as an environment variable - used for encrypting outgoing data
    public_key: `MATAARA_PUB_KEY`
    # Frequency that the client will send data, expressed in seconds
    interval: 86400
PhpTek\Mataara\Report\AbstractReport:
  opts:
    # The version of the JSON report
    version: 1

```

2. Setup `symbiote/silverstripe-queuedjobs` as per [its instructions](https://github.com/symbiote/silverstripe-queuedjobs)
  
**Note** If your app is hosted in a multi-node cloud environment such as Azure App Services, AWS Fargate or K8s, you'll definetely need to setup a dedicated container just for the cron.

# TODO

* Ascertain if Mataara can generate or send alerts to arbitrary addresses or endpoints. If not, submit an issue to add it
* Ascertain exactly how the `ReportType` report-field works. What exactly does it drive within Mataara? It's confusing that the default
  report format appears to be fixed, but that this field _appears_ to determine how reports are processed. Additonally, there is future work to
  version the JSON so this module will support this out-of-the-box in anticipation of this.
* How does Mataara inspect modules for CVEs? 

# See Also

* [`phptek/silverstripe-sentry`](https://github.com/phptek/silverstripe-sentry) Silverstripe Sentry module (Maintained by Russ Michell)
* [Mataara Issue Tracker](https://gitlab.com/mataara/Mataara-Server/-/issues/)
