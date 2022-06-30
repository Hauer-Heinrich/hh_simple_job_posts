# hh_simple_job_posts
hh_simple_job_posts is a TYPO3 extension.
Lists and shows job posts / job offers incl. schema.org stuff (e. g. for google jobs) and (if you have EXT:hh_seo loaded) meta-tags.
ATTENTION: for google jobs you have to send HTTP requests to the google indexing api (for update/create and delete)

### optional

* [hh_seo] - works well with: https://github.com/Hauer-Heinrich/hh_seo - required if you want use Partial/MetaTags.html


### Installation
... like any other TYPO3 extension

google_for_jobs:
- add sitemap.typoscript config to your theme / template
'''
plugin.tx_seo {
    config {
        xmlSitemap {
            sitemaps {
                jobs {
                    provider = HauerHeinrich\HhSimpleJobPosts\XmlSitemap\RecordsXmlSitemapDataProvider
                    config {
                        table = tx_hhsimplejobposts_domain_model_jobpost
                        sortField = sorting
                        lastModifiedField = tstamp
                        recursive = 1
                        ### Speicherort der Beiträge
                        pid = <pageID of JobPosting-Folder>
                        url {
                            ### PageID der Detailseite
                            pageId = <pageID of detailview>
                            fieldToParameterMap {
                                uid = tx_hhsimplejobposts_jobslist[jobpost]
                            }
                            additionalGetParameters {
                                tx_hhsimplejobposts_jobslist.controller = Jobpost
                                tx_hhsimplejobposts_jobslist.action = show
                            }
                            useCacheHash = 1
                        }
                    }
                }
            }
        }
    }
}
'''

- add routeEnhancers from config.yaml to your siteconfig
'''
routeEnhancers:
  JobPluginDetail:
    type: Extbase
    extension: HhSimpleJobPosts
    plugin: jobsdetail
    defaultController: 'Jobpost::switch'
    routes:
      - routePath: '/{job_slug}'
        _controller: 'Jobpost::switch'
        _arguments:
          job_slug: jobpost
    aspects:
      job_slug:
        type: PersistedAliasMapper
        tableName: tx_hhsimplejobposts_domain_model_jobpost
        routeFieldName: slug
  JobPluginList:
    type: Extbase
    extension: HhSimpleJobPosts
    plugin: jobslist
    defaultController: 'Jobpost::list'
    routes:
      - routePath: '/{job_slug}'
        _controller: 'Jobpost::show'
        _arguments:
          job_slug: jobpost
      - routePath: '/detail/{job_slug}'
        _controller: 'Jobpost::switch'
        _arguments:
          job_slug: jobpost
      - routePath: '/'
        _controller: 'Jobpost::list'
    aspects:
      job_slug:
        type: PersistedAliasMapper
        tableName: tx_hhsimplejobposts_domain_model_jobpost
        routeFieldName: slug
'''

### Features
- automatically generates config for sitemap (EXT:seo)
- compatible with EXT:hh_seo
- shippes default config for nice-urls

### Register new or Delete Job-Postings:
- send a POST to following URL: " https://indexing.googleapis.com/v3/urlNotifications:publish "
- text-content of Request must have "url" and "type" attributes with following syntax:
    { // for example
        "url": "https://your-website.com/jobs/google/technical-writer",
        "type": "URL_UPDATED" // or 'URL_DELETED' to remove jobPost on next crawl
    }
- if you use "URL_DELETED" make sure that the 'validThrough' DateTime of the JobPosting is in the past, else it will be ignored
- if your request was successful, googles response is a "HTTP 200 Success",
    -> if you don't get a "HTTP 200" Response see: (https://developers.google.com/search/apis/indexing-api/v3/core-errors#api-errors)
- default Quota of publish requests like "URL_UPDATED" or  "URL_DELETED" is 200 daily / project (normally enough - but for more use the Google API Console: https://console.cloud.google.com/apis/api/indexing.googleapis.com/quotas)

### Todos
- improve readme
- maybe add functions for automatic publish-requests to Google Indexing API


### Deprecated
- currently nothing


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
