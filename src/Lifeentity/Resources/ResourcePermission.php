<?php namespace Lifeentity\Resources;

use Lifeentity\Membership\User;

class ResourcePermission {

	/**
	 * Account
	 * @var User
	 */
	protected $user;

	/**
	 * Permissions array
	 * @var array
	 */
	protected $permissions;

    /**
     * Constructor
     * @param array $permissions
     * @param \Lifeentity\Membership\User $user
     */
	public function __construct(array $permissions, User $user = null)
	{
		$this->permissions = $permissions;
		$this->user = $user;
	}

    /**
     * Returns true if this user has permissions to access this method on this resource
     * @param \Lifeentity\Resources\Resource|Resource $resource
     * @param  ResourceRequest $request
     * @return boolean
     */
	public function allowed(Resource $resource, ResourceRequest $request)
	{
		// Get required roles
		$roles = $this->getDefinedRoles($resource->name(), $request->getAction());

		// If no roles defined then return true
		if(empty($roles)) return true;

		// If user is null then return false
		if(is_null($this->user)) return false;

		// Loop through all defined roles (OR)
		foreach($roles as $role)
		{
			$requiredRoles = $this->extractRolesFrom($role);

			// If user has all roles then return true (AND)
			if($this->user->hasRoles($requiredRoles))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Get all defined roles
	 * @param  string $resourceName
	 * @param  string $action
	 * @return array
	 */
	protected function getDefinedRoles($resourceName, $action)
	{
		if(isset($this->permissions[$resourceName]) && isset($this->permissions[$resourceName][$action]))
		{
			return $this->permissions[$resourceName][$action];
		}

		return array();
	}

	/**
	 * Extract roles from string
	 * @param  string $string
	 * @return array
	 */
	protected function extractRolesFrom($string)
	{
		return explode(',', $string);
	}

}