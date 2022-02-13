<?php

namespace Armincms\Papyrus\Gutenberg\Templates; 

use Zareismail\Gutenberg\Template; 
use Zareismail\Gutenberg\Variable;

class SinglePage extends Template 
{        
    /**
     * The logical group associated with the template.
     *
     * @var string
     */
    public static $group = 'Page';

    /**
     * Register the given variables.
     * 
     * @return array
     */
    public static function variables(): array
    {
        return [ 
            Variable::make('id', __('Page Id')),

            Variable::make('name', __('Page Name')),

            Variable::make('url', __('Page URL')),

            Variable::make('hits', __('Page Hits')),

            Variable::make('creation_date', __('Page Creation Date')),

            Variable::make('last_update', __('Page Update Date')),

            Variable::make('author', __('Page Author')),

            Variable::make('summary', __('Page Summary')),

            Variable::make('content', __('Page Content')),

            Variable::make('image.templateName', __(
                'Image with the required template (example: image.common-main)'
            ))
        ];
    } 
}
