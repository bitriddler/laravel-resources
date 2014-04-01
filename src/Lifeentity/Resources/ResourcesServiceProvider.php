<?php namespace Lifeentity\Resources;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Lifeentity\Resources\Input\InputData;

class ResourcesServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        // Register web services request handling start point
        Route::get('/web-services/{resource}/{all?}', function($resource, $all = '')
        {
            // Create new resource request
            $request = ResourceRequest::make($all, Request::getMethod());

            // If couldn't get resource by name from the respoitory throw an exception
            if(! $resource = App::make('Lifeentity\Resources\ResourceRepository')->getByName($resource))
            {
                throw new ResourceException("We can't find this resource in our application: {{$resource}}");
            }

            // Call this resource
            return App::make('Lifeentity\Resources\ResourceManager')->call($resource, $request, new InputData(Input::all()));

        })->where('all', '.*');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
