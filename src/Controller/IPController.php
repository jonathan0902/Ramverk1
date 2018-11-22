<?php

namespace Anax\Controller;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class IPController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public function ipActionGet() : string
    {
        $iptest = ["212.212.100.110", "0000:0000:0000:a000:0000:0000:0000:0001c"];
        $empty = [];

        for ($i=0; $i < count($iptest); $i++) {
            if (filter_var($iptest[$i], FILTER_VALIDATE_IP)) {
                $empty[$i] = ["ip" => "$iptest[$i] is a valid IP address"];
            } else {
                $empty[$i] = ["ip" => "$iptest[$i] is not a valid IP address"];
            }
        }
        return json_encode($empty, JSON_PRETTY_PRINT);
    }

    public function ipSelfActionGet($iptest = "212.212.100.110")
    {
        $iptest = $this->di->get("request")->getGet('ip', "212.212.100.110");
        $empty = [];
        if (filter_var($iptest, FILTER_VALIDATE_IP)) {
            $empty[0] = ["ip" => "$iptest is a valid IP address"];
        } else {
            $empty[0] = ["ip" => "$iptest is not a valid IP address"];
        }
        $page = $this->di->get("page");
        $print = json_encode($empty, JSON_PRETTY_PRINT);
        $page->add("ip/ip", [
            "print" => $print
        ]);
        return $page->render();
    }

    public function mapJSONActionGet($iptest = "193.11.184.65") : string
    {
        $response = [];
        if (filter_var($iptest, FILTER_VALIDATE_IP)) {
            $response[0] = [$this->APIKey("http://api.ipstack.com/193.11.184.65?access_key=ed136a396b51d26d5b29fecaeb0738ae")];
        } else {
            $response[0] = ["ip" => "$iptest is not a valid IP address"];
        }
        return json_encode($response[0], JSON_PRETTY_PRINT);
    }

    public function ipMapActionGet()
    {
        $page = $this->di->get("page");
        $iptest = $this->di->request->getGet('ipMap', "193.11.184.65");
        $empty = [];
        if (filter_var($iptest, FILTER_VALIDATE_IP)) {
            $response = $this->APIKey("http://api.ipstack.com/$iptest?access_key=ed136a396b51d26d5b29fecaeb0738ae");
            $page->add("ip/map", [
                "ip" => $response["ip"],
                "country" => $response["country_name"],
                "region_name" => $response["region_name"],
                "city" => $response["city"],
                "zip" => $response["zip"]
            ]);
        } else {
            $empty[0] = ["ip" => "$iptest is not a valid IP address"];
        }

        return $page->render();
    }

    public function apiKey($api = "")
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "$api",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }
}
