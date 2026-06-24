<?php

namespace App\Controllers\Owner;

class DashboardController extends \App\Controllers\Admin\DashboardController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
}
