<?php namespace Lifeentity\Resources;

use Lifeentity\Resources\Input\InputData;

class ResourceManager {

	/**
	 * Resource permissions
	 * @var ResourcePermission
	 */
	protected $permissions;

	/**
	 * Resource permissions
	 * @param ResourcePermission $permissions
	 */
	public function __construct(ResourcePermission $permissions)
	{
		$this->permissions = $permissions;
	}

    /**
     * Call this resource with the given method, arguments and input data
     * @param \Lifeentity\Resources\Resource|Resource $resource
     * @param  ResourceRequest $request
     * @param  InputData $inputs
     * @throws ResourceException
     * @return mixed
     */
	public function call(Resource $resource, ResourceRequest $request, InputData $inputs)
	{
		if($this->permissions->allowed($resource, $request))
		{
			// Set inputs for this resource
			$resource->setInputs($inputs);

			// Call the method with the arguments on this resource
			return $resource->call($request);
		}

		throw new ResourceException("You don't have permissions to request `{$request}` on this resource: {{$resource->name()}}");
	}

}