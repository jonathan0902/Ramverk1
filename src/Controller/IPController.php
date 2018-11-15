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

    public function ipSelfActionGet($iptest = "212.212.100.110") : string
    {
        $empty = [];
        if (filter_var($iptest, FILTER_VALIDATE_IP)) {
            $empty[0] = ["ip" => "$iptest is a valid IP address"];
        } else {
            $empty[0] = ["ip" => "$iptest is not a valid IP address"];
        }
        return json_encode($empty, JSON_PRETTY_PRINT);
    }
}
