// src/bootstrap.php
<?php

use Illuminate\Http\Request;

function createRequestFromGlobals()
{
    return Request::capture();
}