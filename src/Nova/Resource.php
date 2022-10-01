<?php

namespace Armincms\Papyrus\Nova;

use Armincms\Contract\Nova\Authorizable;
use Armincms\Contract\Nova\Fields;
use Armincms\Fields\Targomaan;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    use Authorizable;
    use Fields;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('Page ID'), 'id')->sortable(),

            $this->when($request->isResourceDetailRequest(), function () {
                return $this->resourceUrls();
            }),

            Targomaan::make([
                Select::make(__('Page Status'), 'marked_as')
                    ->options($this->statuses($request))
                    ->required()
                    ->rules('required')
                    ->default('draft'),

                Text::make(__('Page Name'), 'name')
                    ->required()
                    ->rules('required'),

                Text::make(__('Page Slug'), 'slug')
                    ->nullable(),

                $this->resourceImage(__('Page Featured Image')),

                Textarea::make(__('Page Summary'), 'summary')
                    ->nullable(),

                $this->resourceEditor(__('Page Content'), 'content'),

                Hidden::make('resource')
                    ->default(get_called_class())
                    ->onlyOnForms()
                    ->hideWhenUpdating(),
            ]),

            Panel::make(__('Advanced Page Configurations'), [
                Targomaan::make([
                    $this->resourceMeta(__('Page Meta')),
                ]),
            ]),
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fieldsForIndex(Request $request)
    {
        $model = static::newModel();

        return [
            ID::make(__('Page ID'), 'id')->sortable(),

            Text::make(__('Page Name'), 'name'),

            $this->resourceUrls(),

            Badge::make(__('Page Status'), 'marked_as')
                ->map([
                    $model->getPublishValue() => 'success',
                    $model->getDraftValue() => 'info',
                    $model->getArchiveValue() => 'warning',
                    $model->getPendingValue() => 'danger',
                ])
                ->labels([
                    $model->getPublishValue() => __($model->getPublishValue()),
                    $model->getDraftValue() => __($model->getDraftValue()),
                    $model->getArchiveValue() => __($model->getArchiveValue()),
                    $model->getPendingValue() => __($model->getPendingValue()),
                ]),
        ];
    }

    /**
     * Get the page statuses.
     *
     * @param  Request  $request
     * @return array
     */
    public function statuses(Request $request)
    {
        $model = static::newModel();

        return $this->filter([
            $model->getDraftValue() => __('Store page as draft'),

            $this->mergeWhen($request->user()->can('publish', $model), function () use ($model) {
                return [
                    $model->getPublishValue() => __('Publish the page'),
                ];
            }, function () use ($model) {
                return [
                    $model->getPendingValue() => __('Request page publishing'),
                ];
            }),

            $this->mergeWhen($request->user()->can('archive', $model), function () use ($model) {
                return [
                    $model->getArchiveValue() => __('Archive the page'),
                ];
            }),
        ]);
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->localize();
    }

    /**
     * Build a Scout search query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Laravel\Scout\Builder  $query
     * @return \Laravel\Scout\Builder
     */
    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    /**
     * Build a "detail" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    /**
     * Build a "relatable" query for the given resource.
     *
     * This query determines which instances of the model may be attached to other resources.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }
}
