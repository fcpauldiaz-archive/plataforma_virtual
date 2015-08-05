<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    /**
     * Don't forget to add this route annotation!
     *
     * @Route("/", name="admin")
     */
    public function indexAction(Request $request)
    {
        // if the URL doesn't include the entity name, this is the index page
        

        // don't forget to add this line to serve the regular backend pages
        return parent::indexAction($request);
    }

    public function createNewUsersEntity()
	{
	   return $this->container->get('fos_user.user_manager')->createUser();
	}

	public function prePersistUsersEntity(User $user)
	{
	   $this->container->get('fos_user.user_manager')->updateUser($user, false);
	}

	public function preUpdateUsersEntity(User $user)
	{
	   $this->container->get('fos_user.user_manager')->updateUser($user, false);
	}

    // ...
}