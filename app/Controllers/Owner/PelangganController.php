<?php

namespace App\Controllers\Owner;

class PelangganController extends \App\Controllers\Admin\PelangganController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
}
