<?php

namespace Armincms\Papyrus\Cypress\Widgets;

use Zareismail\Cypress\Http\Requests\CypressRequest; 
use Zareismail\Gutenberg\GutenbergWidget;

abstract class PapyrusPage extends GutenbergWidget
{        
    /**
     * Indicates if the widget should be shown on the component page.
     *
     * @var \Closure|bool
     */
    public $showOnComponent = false;

    /**
     * Bootstrap the resource for the given request.
     * 
     * @param  \Zareismail\Cypress\Http\Requests\CypressRequest $request 
     * @param  \Zareismail\Cypress\Layout $layout 
     * @return void                  
     */
    public function boot(CypressRequest $request, $layout)
    {   
        parent::boot($request, $layout);

        $this->withMeta([
            'resource' => $request->resolveFragment()->metaValue('resource')
        ]);
    } 

    /**
     * Serialize the widget fro template.
     * 
     * @return array
     */
    public function serializeForDisplay(): array
    { 
        return $this->metaValue('resource')->serializeForWidget($this->getRequest());
    }

    /**
     * Query related dispaly templates.
     * 
     * @param  $request 
     * @param  $query   
     * @return          
     */
    public static function relatableTemplates($request, $query)
    {
        $query->handledBy(\Armincms\Papyrus\Gutenberg\Templates\SinglePage::class);
    } 
}
