<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 2018-11-28
 * Time: 08:16
 */

namespace Anax\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

class IpControllerTest extends TestCase
{

    // Create the di container.
    protected $di;
    protected $controller;

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
         $this->assertContains("is a valid IP address", $res);
    }
    /**
     * Test the route "index".
     */
    public function testIPSelfWorkGetActionGet()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $res = $controller->ipSelfActionGet("212.212.100.110");
        $this->assertNotNull($res);
    }
    /**
     * Test the route "index".
     */
    public function testIPSelfFailedActionGet()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $this->di->get("request")->setGet('ip', "212.212.100.1102222222222222222222222222222222222");
        $res = $controller->ipSelfActionGet();
        $this->assertNotNull($res);
    }

    /**
     * Test the route "index".
     */
    public function testMapJSONActionActionGet()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $res = $controller->mapJSONActionGet("212.212.100.110");
        $this->assertNotNull($res);
    }

    public function testMapJSONActionFailedActionGet()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $res = $controller->mapJSONActionGet("212.212.100.1102222222222222222222222222222222222");
        $this->assertNotNull($res);
    }

    public function testIpMapActionGet()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $this->di->get("request")->setGet('ipMap', "212.212.100.110");
        $res = $controller->ipMapActionGet();
        $this->assertNotNull($res);
    }

    public function testIpMapFailedActionGet()
    {
        $controller = new IPController();
        $controller->setDI($this->di);
        $this->di->get("request")->setGet('ipMap', "212.212.100.1102222222222222222222222222222222222");
        $res = $controller->ipMapActionGet();
        $this->assertNotNull($res);
    }
}
