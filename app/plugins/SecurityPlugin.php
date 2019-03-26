<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Acl;
use Phalcon\Acl\Role;
use Phalcon\Acl\Adapter\Memory as AclList;
use Phalcon\Acl\Resource;

class SecurityPlugin extends Plugin
{
	public const ADMIN = 'admin';
	public const READONLY = 'readonly';
	public const GUEST = 'guest';

    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        // Check whether the 'auth' variable exists in session to define the active role
        $auth = $this->session->get('auth');

        if (!$auth) {
            $role = self::GUEST;
        } else {
        	//ENUM('admin', 'readonly')
            $role = $auth['role'];
        }

        // Take the active controller/action from the dispatcher
        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        // Obtain the ACL list
        $acl = $this->getAcl();

        // Check if the Role have access to the controller (resource)
        $allowed = $acl->isAllowed($role, $controller, $action);

        if (!$allowed) {
            // If he doesn't have access forward him to the index controller
            // $this->flash->error(
            //     "You don't have access to this module"
            // );
            switch ($role) {
            	case self::GUEST:
        			// $dispatcher->forward(
		            //     [
		            //         'controller' => 'index',
		            //         'action'     => 'index',
		            //     ]
					// );
					$this->response->redirect('index');
            		break;
            	case self::ADMIN:
        			// $dispatcher->forward(
		            //     [
		            //         'controller' => 'material_value',
		            //         'action'     => 'index',
		            //     ]
					// );
					$this->response->redirect('material_value/index');
            		break;
            	case self::READONLY:
        			// $dispatcher->forward(
		            //     [
		            //         'controller' => 'index',
		            //         'action'     => 'index',
		            //     ]
					// );
					$this->response->redirect('index');
            		break;
            	
            	default:
            		# code...
            		break;
            }


            // Returning 'false' we tell to the dispatcher to stop the current operation
            return false;
        }
    }
    private function getAcl(){
    	// Create the ACL
		$acl = new AclList();

		// The default action is DENY access
		$acl->setDefaultAction(
		    Acl::DENY
		);

		// Register two roles, Users is registered users
		// and guests are users without a defined identity
		$roles = [
		    self::ADMIN  => new Role(self::ADMIN),
		    self::READONLY  => new Role(self::READONLY),
		    self::GUEST => new Role(self::GUEST),
		];

		foreach ($roles as $role) {
		    $acl->addRole($role);
		}
		// Private area resources (backend)
		$allPrivateResources = [
			'material_value'=> ['index','search','new','edit','create','delete','save','show','qr',
								'licenses','search_licenses','add_license','rem_license',
								'specifications','search_specifications','add_specification','rem_specification'],
		    'furniture'		=> ['index','search','new','edit','create','delete','save'],
		    'equipment'		=> ['index','search','new','edit','create','delete','save'],
		    'license'		=> ['index','search','new','edit','create','delete','save'],
		    'location'		=> ['index','search','new','edit','create','delete','save'],
			'session'		=> ['logout','index'],
			'specifications'=> ['index','search','new','edit','create','delete','save'],
			'index'			=> ['index'],
		];
		$adminResources = [
			'material_value'=> ['index','search','new','edit','create','delete','save','show','qr',
								'licenses','search_licenses','add_license','rem_license',
								'specifications','search_specifications','add_specification','rem_specification'],
		    'furniture'		=> ['index','search','new','edit','create','delete','save'],
		    'equipment'		=> ['index','search','new','edit','create','delete','save'],
		    'license'		=> ['index','search','new','edit','create','delete','save'],
			'location'		=> ['index','search','new','edit','create','delete','save'],
			'specifications'=> ['index','search','new','edit','create','delete','save'],
			'session'		=> ['logout'],
			'index'			=> ['index'],
		];
		$readonlyResources = [
			'session'		=> ['logout'],
		    'index'			=> ['index'],
			'material_value'=> ['show','qr'],
		];
		$guestResources = [
		    'index'			=> ['index'],
		    'session'		=> ['index'],
		];

		foreach ($allPrivateResources as $resourceName => $actions) {
		    $acl->addResource(
		        new Resource($resourceName),
		        $actions
		    );
		}

		// Public area resources (frontend)
		$publicResources = [
		    'errors'   => ['show404', 'show500'],
		];

		foreach ($publicResources as $resourceName => $actions) {
		    $acl->addResource(
		        new Resource($resourceName),
		        $actions
		    );
		}
		// Grant access to public areas to both users and guests
		foreach ($roles as $role) {
		    foreach ($publicResources as $resource => $actions) {
		    	foreach ($actions as $action) {
			        $acl->allow(
			            $role->getName(),
			            $resource,
			            $action
			        );
			    }
		    }
		}

		// Grant access to private area only to role Users
		foreach ($adminResources as $resource => $actions) {
		    foreach ($actions as $action) {
		        $acl->allow(
		            self::ADMIN,
		            $resource,
		            $action
		        );
		    }
		}
		foreach ($readonlyResources as $resource => $actions) {
		    foreach ($actions as $action) {
		        $acl->allow(
		            self::READONLY,
		            $resource,
		            $action
		        );
		    }
		}
		foreach ($guestResources as $resource => $actions) {
		    foreach ($actions as $action) {
		        $acl->allow(
		            self::GUEST,
		            $resource,
		            $action
		        );
		    }
		}
		return $acl;
    }
}