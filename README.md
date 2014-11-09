WYPiwik
=======

A [YOURLS](http://yourls.org) plugin for tracking with [Piwik](http://piwik.org/)


## Features

* Logs all requests with Piwik
* Tracks IP and custom variables
* Lets you disable local tracking/stats
* Includes "Don't Log Bots" from OZH


## Requirements

* PHP 5.3
* PiwikTracker.php from your Piwik installation

## Setup

### YOURLS
* Pull the files to <yourls_root>/user/plugins/piwik
* Place PiwikTracker.php into the <yourls_root>/user/plugins/piwik/libs/Piwik folder
* Activate the plugin in the admin zone of YOURLS
* Go to the plugin page and fill in the required fields

If you want better alert messages, you need to [apply this change](https://code.google.com/p/yourls/source/detail?r=787) to your YOURLS installation.

### Piwik

* Create a test "website" and use that at the beginning until you find the right way to log your hits
* Create or assign an admin auth token to that site
* Visit some of your links
* Check the hits on the "Visitors in real-time" widget

## Modifications

If you're not happy with the way hits are tracked, just change the way the plugin does it by editing:

		// This shows up in the visitor logs and identify the source of the data
		$pt->setCustomVariable(1, 'App', 'Piwik plugin for YOURLS', 'visit');

		// Some useful variables
		$pt->setCustomVariable(2, 'Domain landed', $domain_landed, 'page');
		$pt->setCustomVariable(3, 'Keyword', $keyword, 'page');

		// Track the visit in Piwik
		$title = yourls_get_keyword_title($keyword);
		@$pt->doTrackPageView($title);

		// The destination URL will show up as an outlink
		@$pt->doTrackAction($destination, 'link');

in plugin.php, function "itfs_piwik_log_request"


## Inspiration

 * [Piwik Yourls plugin](https://github.com/interfasys/piwik-yourls)
 * [Piwik plugin thread](https://code.google.com/p/yourls/issues/detail?id=661)
 * [Google Analytics plugin](http://www.seodenver.com/yourls-analytics/)
 * [WP-Piwik Wordpress plugin](http://wordpress.org/extend/plugins/wp-piwik/)

## License
