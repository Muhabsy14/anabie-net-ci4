<?php

namespace App\Controllers\Owner;

class LaporanController extends \App\Controllers\Admin\LaporanController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
    protected string $jenisLaporan = 'resmi';
}
