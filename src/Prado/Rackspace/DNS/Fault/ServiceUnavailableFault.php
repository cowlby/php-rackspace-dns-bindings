<?php

namespace Prado\Rackspace\DNS\Fault;

use Prado\Rackspace\DNS\Model\CloudDNSFault;

class ServiceUnavailableFault extends \RuntimeException implements CloudDnsFault
{
}
