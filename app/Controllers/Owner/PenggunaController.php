<?php

namespace App\Controllers\Owner;

class PenggunaController extends \App\Controllers\Admin\PenggunaController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
}
