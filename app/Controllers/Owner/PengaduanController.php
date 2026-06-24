<?php

namespace App\Controllers\Owner;

class PengaduanController extends \App\Controllers\Admin\PengaduanController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
}
