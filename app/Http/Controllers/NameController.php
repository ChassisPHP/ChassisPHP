<?php

namespace App\Http\Controllers;

class NameController
{
    public function show($vars)
    {
        return "Well, hello $vars[name] !!";
    }
}
