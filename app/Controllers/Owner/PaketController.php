<?php

namespace App\Controllers\Owner;

class PaketController extends \App\Controllers\Admin\PaketController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
}
