<?php

namespace LoggerTest;

use Logger\Logger;

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $first = Logger::getInstance();
        $second = Logger::getInstance();

        $this->assertSame($first, $second);
    }

    /**
     * @expectedException Exception
     */
    public function testSendThrowsExceptionIfApiKeyIsNotSet()
    {
        $logger = Logger::getInstance();
        $logger->info('Info log', ['foo' => 'bar']);
    }

    public function testSetApiKey()
    {
        $logger = Logger::getInstance();
        $logger->setApiKey('pGAizgDjilTEcjDlTsnlMNudpDaiREVe');
    }

    public function testSetBulk()
    {
        $logger = Logger::getInstance();
        $logger->setBulk(true);
    }

    public function testLogInfo()
    {
        $logger = Logger::getInstance();
        $logger->info('Info log', ['foo' => 'bar']);
    }

    public function testLogWarning()
    {
        $logger = Logger::getInstance();
        $logger->warning('Warning log', ['foo' => 'bar']);
    }

    public function testLogError()
    {
        $logger = Logger::getInstance();
        $logger->error('Error log', ['foo' => 'bar']);
    }

    public function testLogDebug()
    {
        $logger = Logger::getInstance();
        $logger->debug('Debug log', ['foo' => 'bar']);
    }

    /**
     * @expectedException Exception
     */
    public function testSendThrowsExceptionIfBulkIsFalse()
    {
        $logger = Logger::getInstance();
        $logger->setBulk(false);
        $logger->send();
    }

    public function testSendWithZeroLogs()
    {
        $logger = Logger::getInstance();
        $logger->setBulk(true);
        $logger->send();
    }

    public function testSend()
    {
        $logger = Logger::getInstance();
        $logger->setBulk(true);
        $logger->info('Info log', ['foo' => 'bar']);
        $logger->error('Error log', ['foo' => 'bar']);
        $logger->send();
    }
}