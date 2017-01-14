# PHP Logger

PHP library to send realtime logs to Logz.io, an ELK as a service.

### Installing

Install with composer:

```sh
$ composer require vagnercsouza/logger
```

### Usage

First of all, you need an account on Logz.io. Then, go to you profile settings and get your api key (token).

**Configure**
To configure the library, you just need to get an instance of Logger and set the api key. You need to do it once:

```sh
\Logger\Logger::getInstance()->setApiKey('TOKEN_HERE');
```

You can eather set an application name to identify the logs if you have more than one app sending logs:

```sh
\Logger\Logger::getInstance()->setApplication('My App Name');
```

**Sending logs**
To send a log, you need to get an instance of Logger and use one of the following functions:

```sh
// Send an info log
\Logger\Logger::getInstance()->info('My info log');

// Send an warning log
\Logger\Logger::getInstance()->warning('My warning log');

// Send an error log
\Logger\Logger::getInstance()->error('My error log');

// Send an debug log
\Logger\Logger::getInstance()->debug('My debug log');
```

**Sending multiple logs**
By default, the log is delivered to Logz.io right after you call the info, warning, error or debug functions. If you need to send more than one log, you can enable the bulk option, which will wait until you call the send function to actually deliver the logs to Logz.io.

```sh
// Enable the bulk mode
\Logger\Logger::getInstance()->setBulk(true);

// Send as many logs as you want
\Logger\Logger::getInstance()->warning('My warning log');
\Logger\Logger::getInstance()->error('My error log');
\Logger\Logger::getInstance()->warning('My second warning log');

// Finally, deliver the logs to Logz.io
\Logger\Logger::getInstance()->send();
```

**Sending parameters**
If you need to send parameters with the log, you just need to pass an array as second parameter of the logs functions:

```sh
// Send an info log
\Logger\Logger::getInstance()->info('My info log', ['user' => 1213]);

// Send an warning log
\Logger\Logger::getInstance()->warning('My warning log', ['foo' => 'bar']);

// Send an error log
\Logger\Logger::getInstance()->error('My error log', ['line' => 18]);

// Send an debug log
\Logger\Logger::getInstance()->debug('My debug log', ['foo' => 'bar']);
```

### Contributing

To contribute, create a fork, make your changes, make tests, test and create a PR.


### License

This library is licenced under MIT.