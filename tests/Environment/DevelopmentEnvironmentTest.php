<?php

/**
 * @coversDefaultClass \nkm\RedsysVirtualPos\Environment\DevelopmentEnvironment
 */
class DevelopmentEnvironmentTest extends PHPUnit_Framework_TestCase
{
    private $className          = '\nkm\RedsysVirtualPos\Environment\DevelopmentEnvironment';
    private $exceptionClassName = '\nkm\RedsysVirtualPos\Environment\EnvironmentException';

    private $environment;

    public function setUp()
    {
        $this->environment = new $this->className();
    }

    public function getEmptyProvider()
    {
        return [
            [''],
            [0],
            [0.0],
            ['0'],
            [null],
            [[]],
            [new stdClass],
        ];
    }

    /**
     * @covers ::getSecret
     */
    public function testGetSecretDefault()
    {
        $this->assertEquals('Mk9m98IfEblmPfrpsawt7BmxObt98Jev', $this->environment->getSecret());
    }

    /**
     * @covers          ::getSecret
     * @dataProvider    getEmptyProvider
     */
    public function testGetSecretEmpty($newSecret)
    {
        $this->setExpectedException(
            $this->exceptionClassName,
            'Merchant secret is not set.'
        );

        $this->environment->setSecret($newSecret);

        $this->environment->getSecret();
    }

    public function setSecretProvider()
    {
        return [
            ['This cosmic dance﻿ of bursting decadence and withheld permissions'],
            ['twists all our arms collectively, but if sweetness can win, and it can,'],
            ['then I\'ll still be here tomorrow, to high five you yesterday my friend.'],
            ['Peace'],
        ];
    }

    /**
     * @covers          \nkm\RedsysVirtualPos\Environment\DevelopmentEnvironment::setSecret
     * @dataProvider    setSecretProvider
     */
    public function testSetSecret($newSecret)
    {
        $this->environment->setSecret($newSecret);

        $this->assertEquals($newSecret, $this->environment->getSecret());
    }

    public function getEndpointProvider()
    {
        return [
            [true,  '/whatevs',                'http://sis-d.redsys.es/whatevs'],
            [true,  '/Oh-My-Glob',             'http://sis-d.redsys.es/Oh-My-Glob'],
            [true,  'this-is-wrong-but-valid', 'http://sis-d.redsys.esthis-is-wrong-but-valid'],
            [false, 'this-is-not-valid',       'http://sis-d.redsys.es/this-is-not-valid'],
            [false, 'this-is-not-valid',       ''],
        ];
    }

    /**
     * @covers          \nkm\RedsysVirtualPos\Environment\DevelopmentEnvironment::getEndpoint
     * @dataProvider    getEndpointProvider
     */
    public function testGetEndpoint($expected, $partialEndpoint, $fullEndpoint)
    {
        $this->assertEquals(
            $expected,
            $this->environment->getEndpoint($partialEndpoint) === $fullEndpoint
        );
    }

    /**
     * @covers          \nkm\RedsysVirtualPos\Environment\DevelopmentEnvironment::getEndpoint
     * @dataProvider    getEmptyProvider
     */
    public function testGetEndpointEmpty($endpoint)
    {
        $this->setExpectedException('\InvalidArgumentException');

        $this->environment->getEndpoint($endpoint);
    }
}
