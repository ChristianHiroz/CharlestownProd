<?php

namespace Charlestown\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CharlestownUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
