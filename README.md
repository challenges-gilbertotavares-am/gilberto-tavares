# Gilberto Tavares

Awesome Motive Developer Applicant Challenge part 1

## Requirements

* PHP 7.4+
* WordPress 6.1+

## Installation

1. Download the latest version of the plugin.
2. Upload the plugin to your WordPress site.
3. Activate the **Gilberto Tavares** plugin.

### Local Testing Alternative

You can use `wp-now` to test the plugin locally.

```shell
npm i -g @wp-now/wp-now
cd gilberto-tavares
wp-now start
```

This will open a WordPress instance with the plugin activated.

> **Note:** Requires Node.js and NPM.

## Features

The plugin provides the following features:

### AJAX Endpoint

The plugin adds an internal AJAX endpoint that can be private or public. It requires a nonce for authentication. The endpoint mirrors requests from `https://miusage.com/v1/challenge/1/` and implements hourly caching.

### Block for Editor

The **Gilberto Tavares** block formats the JSON response from the custom AJAX endpoint into a table. It also includes toggles for column visibility.

### WP-CLI Command

The plugin includes a WP-CLI command that allows you to clear the cache. Use the following command:

```shell
wp gilberto-tavares flush
```

### Admin Page

The **Gilberto Tavares** admin page displays the cached data as a table and includes a button to force data update.
