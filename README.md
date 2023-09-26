# hh_simple_job_posts
hh_simple_job_posts is a TYPO3 extension.
Lists and shows job posts / job offers incl. schema.org stuff (e. g. for google jobs) and (if you have EXT:hh_seo loaded) meta-tags.

### optional

* [hh_seo] - works well with: https://github.com/Hauer-Heinrich/hh_seo - required if you want use Partial/MetaTags.html

### Installation
... like any other TYPO3 extension

#### Optional
- create a folder at the TYPO3 backend tree in which addresses of hiring-organisations are stored. Then set the UID of this folder at the TYPO3 constants editor ([plugin.tx_hhsimplejobposts.persistence.storagePidOrganizations])
- create a folder at the TYPO3 backend tree in which addresses of contact-point-addresses are stored. Then set the UID of this folder at the TYPO3 constants editor ([plugin.tx_hhsimplejobposts.persistence.storagePidContactPointAddresses])
- both folders can be the same
- for addresses at this 2 folder it is required that the field 'tx_extbase_type' is set to 'ttAddress_location'!
- create a folder at the TYPO3 backend tree in which jobs are stored.

### Features
- automatically generates config for sitemap (EXT:seo)
- compatible with EXT:hh_seo
- shippes default config for nice-urls see example: Configuration/Typo3/sites/config.yaml
- provides psr-14 events

### Available events
When register to an event you can always access the class where the event is fired. For additional items see column "Access to" in the table below.

| Event class | Fired in class | Access to |
| ------------- | ------------- | ------------- |
| JobpostsListEvent | JobpostController | getAssignedValues(), getSettings() |

#### Event description
- JobpostsListEvent: You can set your own Jobposts, for example from external API
  Example Usage see extension https://github.com/Hauer-Heinrich/hh_talentstorm_job_posts
  Add your own "useExternalApi" setting, see: Configuration\TsConfig\Page\TCEFORM.typoscript

#### Connect to event
To connect to an event, you need to register an event listener in your custom extension. All what it needs is an entry in your Configuration/Services.yaml file:

```yaml
services:
  Vendor\Extension\EventListener\YourListener:
    tags:
      - name: event.listener
        identifier: 'your-self-choosen-identifier'
        method: 'yourMethodToConnectToEvent'
        event: HauerHeinrich\HhSimpleJobPosts\Event\JobpostsListEvent
```

#### Write your EventListener
An example event listener can look like this:

```php
<?php
declare(strict_types=1);
namespace Vendor\Extension\EventListener;
use HauerHeinrich\HhSimpleJobPosts\Event\JobpostsListEvent;

/**
 * Use JobpostsListEvent from ext:hh_simple_job_posts
 */
class YourListener {
    /**
     * Do what you want...
     */
    public function yourMethodToConnectToEvent(JobpostsListEvent $event): void {
        $values = $event->getAssignedValues();

        // Do some stuff

        $event->setAssignedValues($values);
    }
}
```

### Todos
- improve readme

##### Copyright notice

This repository is part of the TYPO3 project. The TYPO3 project is
free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

The GNU General Public License can be found at
http://www.gnu.org/copyleft/gpl.html.

This repository is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

This copyright notice MUST APPEAR in all copies of the repository!

##### License
----
GNU GENERAL PUBLIC LICENSE Version 3
