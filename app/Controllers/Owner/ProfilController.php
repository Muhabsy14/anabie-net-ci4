<?php

namespace App\Controllers\Owner;

class ProfilController extends \App\Controllers\Admin\ProfilController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
}
