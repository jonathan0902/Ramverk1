<?php

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class IPControllerTest extends TestCase
{

    // Create the di container.
    protected $di;
    protected $controller;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;
    }
    /**
     * Test the route "index".
     */
    public function testIPAction()
    {
        $controller = new IPController();
        $res = $controller->ipActionGet();
        $this->assertNotNull($res);
    }
    /**
     * Test the route "index".
     */
    public function testIPSelfWorkAction()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $res = $controller->ipSelfActionGet("212.212.100.110");
        $this->assertNotNull($res);
    }

        /*
         *    Test the route "index
         */
    public function testIPSelfFailedAction()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $iptest = $this->di->get("request")->setGet('ip', "2112412.212421.104120.1120");
        $res = $controller->ipSelfActionGet("2112412.212421.104120.1120");
        $this->assertNotNull($res);
    }

    public function testAPIAction()
    {
        $controller = new IPController();
        $iptest = "193.11.184.65";
        $res = $controller->apiKey("http://api.ipstack.com/$iptest?access_key=ed136a396b51d26d5b29fecaeb0738ae");
        $this->assertEquals("193.11.184.65", $res["ip"]);
    }

    public function testMapJSONAction()
    {
        $controller = new IPController();
        $res = $controller->mapJSONActionGet("193.11.184.65");
        $this->assertContains("193.11.184.65", $res);
    }

    public function testMapJSONFailedAction()
    {
        $controller = new IPController();
        $res = $controller->mapJSONActionGet("193.11.184.6534");
        $this->assertContains("is not a valid IP address", $res);
    }

    /**
     * Test the route "index".
     */
    public function testipMapWorkAction()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $iptest = $this->di->get("request")->setGet('ipMap', "212.212.100.110");
        $res = $controller->ipMapActionGet("212.212.100.110");
        $this->assertNotNull($res);
    }

        /*
         *    Test the route "index
         */
    public function testipMapFailedAction()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $iptest = $this->di->get("request")->setGet('ipMap', "2112412.212421.104120.1120");
        $res = $controller->ipMapActionGet("2112412.212421.104120.1120");
        $this->assertNotNull($res);
    }
}
