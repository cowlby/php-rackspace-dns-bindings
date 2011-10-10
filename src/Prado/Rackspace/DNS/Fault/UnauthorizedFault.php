<?php

namespace Prado\Rackspace\DNS\Fault;

use Prado\Rackspace\DNS\CloudDNSFault;

class UnauthorizedFault extends \RuntimeException implements CloudDnsFault
{
}
