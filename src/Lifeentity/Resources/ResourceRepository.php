<?php namespace Lifeentity\Resources;

class ResourceRepository {

	/**
	 * Resources array
	 * @var Resource[]
	 */
	protected static $resources;

    /**
     * Add one more resource to the repository
     * @param \Lifeentity\Resources\Resource $resource
     */
	public static function add(Resource $resource)
	{
		static::$resources[] = $resource;
	}

	/**
	 * Get Resource by name
	 * @param  string $name
	 * @return \Lifeentity\Resources\Resource
	 */
	public static function getByName($name)
	{
		foreach(static::get() as $resource)
		{
			if($resource->check($name))
			{
				return $resource;
			}
		}
	}

	/**
	 * Get description array
	 * @return \Lifeentity\Resources\Resource[]
	 */
	public static function get()
	{
		return static::$resources;
	}

}