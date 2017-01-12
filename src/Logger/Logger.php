<?php

namespace Logger;

use Exception;

class Logger
{
	/*
	 * @var string|null Logz.io API Key
	 */
	private $apiKey = null;

	/*
	 * @var boolean Bulk or single logs
	 */
	private $bulk = false;

	/*
	 * @var array Bulk logs list
	 */
	private $bulkLogs = [];

	/**
     * Get an instance.
     */
	public static function getInstance()
    {
        static $instance = null;

        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * Set the Logz.io token
     *
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
    	$this->apiKey = $apiKey;
    }

    /**
     * Enable or disable bulk mode
     *
     * @param string $apiKey
     */
    public function setBulk($bulk)
    {
    	$this->bulk = $bulk;
    }

    /**
     * Send an info log
     *
     * @param string $message The log message
     * @param array $data Additional data
     */
    public function info($message, array $data = [])
    {
    	$this->log('info', $message, $data);
    }

    /**
     * Send an warning log
     *
     * @param string $message The log message
     * @param array $data Additional data
     */
    public function warning($message, array $data = [])
    {
    	$this->log('warning', $message, $data);
    }

    /**
     * Send an error log
     *
     * @param string $message The log message
     * @param array $data Additional data
     */
    public function error($message, array $data = [])
    {
    	$this->log('error', $message, $data);
    }

    /**
     * Send an debug log
     *
     * @param string $message The log message
     * @param array $data Additional data
     */
    public function debug($message, array $data = [])
    {
    	$this->log('debug', $message, $data);
    }

    /**
     * Send bulk logs
     */
    public function send()
    {
    	if (!$this->bulk) {
    		throw new Exception('The send method only works on bulk mode.');
    	}

    	if (count($this->bulkLogs) > 0) {
	    	$logs = '';

	    	foreach ($this->bulkLogs as $log) {
	    		$data = $log['data'];
	    		$data['type'] = $log['type'];

	    		$logs .= $this->makeLog($log['message'], $data) . "\r\n";
	    	}

	    	$this->sendLog($logs);
	    }
    }

    /**
     * Add the log to list or send now
     *
     * @param string $type The log type
     * @param string $message The log message
     * @param array $data Additional data
     */
    private function log($type, $message, array $data) 
    {
    	if ($this->bulk) {
    		$this->bulkLogs[] = [
    			'type' => $type,
    			'message' => $message,
    			'data' => $data
    		];
    	} else {
	    	$this->sendLog(
	    		$this->makeLog($message, $data),
	    		$type
	    	);
	    }
    }

    /**
     * Send the log to Logz.io
     *
     * @param string $message The log formatted
     * @param string $type The log type
     */
    private function sendLog($log, $type = '')
    {
    	$this->validateSendLog();

    	try {
    		$response = $this->getClient()->post('/', [
    			'query' => [
    				'token' => $this->apiKey,
    				'type' => $type
    			],
    			'body' => $log
    		]);

    		echo $response->getBody();
    	} catch (Exception $e) {
    		echo $e->getMessage();
    	}
    }

    /**
     * Format the log to send
     *
     * @param string $message The log message
     * @param array $data Additional data
     */
    private function makeLog($message, array $data = []) {
    	return json_encode(
    		array_merge(
    			['message' => $message],
    			$data
    		)
    	);
    }

    /**
     * Validate if log can be sent
     */
    private function validateSendLog()
    {
    	if (!$this->apiKey) {
	    	throw new LoggerException('You need to specify the Logz.io api key.');
	    }
    }

    /**
     * Get the Guzzle Client
     *
     * @return \GuzzleHttp\Client
     */
    private function getClient()
    {
    	return new \GuzzleHttp\Client([
    		'base_uri' => 'https://listener.logz.io:8071'
    	]);
    }

	/**
     * Disable constructor to prevent instantiation.
     */
    protected function __construct()
    {
    }

    /**
     * Disable clone to prevent clonning.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Disable wakeup to prefent deserialization.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}