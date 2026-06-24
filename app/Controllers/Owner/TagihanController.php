<?php

namespace App\Controllers\Owner;

class TagihanController extends \App\Controllers\Admin\TagihanController
{
    protected string $panelPrefix = 'owner';
    protected string $layoutView  = 'layouts/owner';
    protected string $roleLabel   = 'Owner';
}
