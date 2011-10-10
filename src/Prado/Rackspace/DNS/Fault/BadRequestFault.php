<?php

namespace Prado\Rackspace\DNS\Fault;

use Prado\Rackspace\DNS\CloudDNSFault;

class BadRequestFault extends \BadMethodCallException implements CloudDnsFault
{
}
