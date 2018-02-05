# PDF Generator

An API for communicating with the PrinceXML service.

## Licence

Copyright &copy; GatenbySanderson Ltd.

This project is open source software released under the terms of the MIT licence: see [LICENCE.md].

## Prerequisites

* PHP >= 7.1
* PrinceXML >= 11.3

## Installing

Follow these steps to get your development environment up and running:

```
vagrant up
vagrant ssh
cd /vagrant && composer install
cp .env.example .env
```

# Getting Started

## Using PHP

We recommend using the [PDF Generator SDK](https://github.com/gatenbysanderson/pdf-generator-sdk) to consume this API. For Laravel projects, we've created a [Laravel package](https://github.com/gatenbysanderson/laravel-pdf-generator) that wraps around the SDK for Laravel-specific requirements, such as compiling and parsing Blade templates before conversion.

Alternatively, use [GuzzleHTTP](http://docs.guzzlephp.org/en/stable/) and make a POST request to the appropriate API endpoint as described below.

## Other Languages

### Request

**URI:** http://192.168.33.99/api/v1/

**Type:** multipart/form-data

**Method:** POST

**Representation:**

```
POST /api/v1/pdf HTTP/1.1
Host: 192.168.33.99
Content-Type: multipart/form-data; boundary=----FormData

------FormData
Content-Disposition: form-data; name="sources[]"; filename="Example Document 1.html"
Content-Type: text/html

------FormData
Content-Disposition: form-data; name="sources[]"; filename="Example Document 2.html"
Content-Type: text/html

------FormData--
```

**Example (PHP):**

```php
<?php

use GuzzleHttp\Client;

$client = new Client();

$request = $client->post(config('domains.pdfgenerator') . '/api/v1/pdf', [
   'multipart' => [
      [
         'Content-type' => 'multipart/form-data',
         'name' => 'sources[]',
         'filename' => 'page1.html',
         'contents' => '... <!DOCTYPE html> ...',
      ],

      // ...
   ],
]);
```

### Response

**Type:** application/json

**Representation:**

```
{
   "status": "success",

   "data": {
       "type": "application/pdf",
       "encoding": "base64",
       "content": "JUVPRgo="
   }
}
```

**Example (PHP):**

```php
<?php

$response = json_decode($request->getBody()->getContents(), false);

$content = $response->data->content;

if ($response->data->encoding === 'base64') {
    $content = base64_decode($content);
}

header('Content-Type: ' . $response->data->type);

header('Content-Disposition: attachment; filename=download.pdf');

echo $content;
```

# Footnotes

* The public root directory that synchronises with the folder on your local machine is located in `/vagrant`
* PHP 7.1 is pre-installed on the development VM — MySQL is not installed as it isn't required
* Virtual host configuration files are located in `/etc/apache2/sites-available/`
* PHP configuration files are located in `/etc/php/7.1/`
* PrinceXML is pre-installed and located at`/usr/bin/prince` - the Microsoft fonts that PrinceXML requires are also included
