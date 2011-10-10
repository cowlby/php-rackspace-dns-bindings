<?php

namespace Prado\Rackspace\DNS\Fault;

use Prado\Rackspace\DNS\CloudDNSFault;

class OverLimitFault extends \RuntimeException implements CloudDnsFault
{
}
