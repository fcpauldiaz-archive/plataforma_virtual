<?php

namespace DocumentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DocumentBundle extends Bundle
{
    public function getParent()
    {
        return 'VichUploaderBundle';
    }
}
