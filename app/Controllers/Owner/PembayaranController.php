<?php

namespace App\Controllers\Owner;

class PembayaranController extends \App\Controllers\Admin\PembayaranController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
}
