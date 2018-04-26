<?php

namespace ServiceJF\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ServiceJFUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
