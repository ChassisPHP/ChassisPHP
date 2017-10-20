<?php

namespace App\Http\Controllers;

class NameController
{
    public function show($vars)
    {
        echo "Well, hello $vars[name] !!";
    }
}
