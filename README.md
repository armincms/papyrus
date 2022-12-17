# papyrus

## Interact With Nova
	First create your resource and extend the `Armincms\Papyrus\Nova\Resource`
	Then create your model and extends the `Armincms\Papyrus\Models\PapyrusPage`
	Then register your resource with Nova

## Interact With Gutenberg
	First create your Cypress fragment and extends `Armincms\Papyrus\Cypress\Fragments\PapyrusPage`
	Then register your fragment with Gutenberg
	And also your widget should extend the `Armincms\Papyrus\Cypress\Widgets\PapyrusPage` to display single page
