<?php

namespace App\Controllers\Owner;

class NotifikasiController extends \App\Controllers\Admin\NotifikasiController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
}
