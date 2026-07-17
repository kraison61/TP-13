<?php

namespace App\View\Composers;

use App\Support\OrganizationSchema;
use App\Support\SeoMeta;
use Illuminate\View\View;

class FrontendLayoutComposer
{
    public function compose(View $view): void
    {
        if (! $view->offsetExists('seo')) {
            $view->with('seo', SeoMeta::resolve($view->getData()));
        }

        if (! $view->offsetExists('organizationSchemaLd')) {
            $view->with('organizationSchemaLd', OrganizationSchema::graph());
        }
    }
}
