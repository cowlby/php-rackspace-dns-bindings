<?php

namespace Prado\Rackspace\DNS\Fault;

use Prado\Rackspace\DNS\CloudDNSFault;

class ItemAlreadyExistsFault extends \RuntimeException implements CloudDnsFault
{
}
