<?php

namespace App\View\Composers;

use App\Models\Custom;
use Illuminate\View\View;

class CustomViewComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $custom = Custom::latest()->first();
        $view->with('siteCustom', $custom);
    }
}