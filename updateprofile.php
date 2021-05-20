<?php

/**
 * @package Plugin user - updateprofile for Joomla! 3.x and Joomla 4 alpha-Beta
 * @version $Id: user - updateprofile 1.0.0 2021-04-21 23:26:33Z $
 * @author KWProductions Co.
 * @(C) 2020-2025.Kian William Productions Co. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of user - updateprofile.
    content - updateprofile is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    plugin user - updateprofile is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with user - updateprofile.  If not, see <http://www.gnu.org/licenses/>.
 
**/

?>

<?php 
defined('_JEXEC') or die;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormHelper;
use Joomla\String\StringHelper;


class PlgUserUpdateprofile extends CMSPlugin
{
	
	protected $autoloadLanguage = true;
	protected $db;
	
	public function onAfterInitialise()
	{
		
		$this->loadLanguage();
	}
	
	public function onUserAfterSave($user, $isNew, $success)
	{
		$app = Factory::getApplication();
				$input = Factory::getApplication()->input;

		if($app->isClient('site')):
		
				$userec = new stdClass();

		$db = $this->db;
		
		/*
		if the admin disable updateprofile and userprofile plugin from backend, later once the admin enable updateprofile
		but forgets to enable userprofile!
		*/
	
		if(!PluginHelper::isEnabled("user","userProfile")):		
  
           
            $query = $db->getQuery(true);
            $query->update('#__extensions');
            $query->set($db->quoteName('enabled') . ' = 1');
            $query->where($db->quoteName('element') . ' = ' . $db->quote('profile'));
            $query->where($db->quoteName('type') . ' = ' . $db->quote('plugin'));
            $db->setQuery($query);
            $db->execute();	
		
		endif;
	
		if($input->get('option')==="com_users")
		{
			


			if(preg_match('/\s+/', $user['name'])){
			  $names = explode(" ", $user['name']);
		  
			  	$userec->f_name = $names[0];
			$userec->l_name = end($names);
			}
			else
			{
				$userec->f_name = $user['name'];
			$userec->l_name = $user['name'];
			}
		
			$userec->u_name = $user['username'];

		
			$userec->email = $user['email'];
			$userec->street = $user['profile']['address1'];
			$userec->zip = $user['profile']['postal_code'];
			$userec->city = $user['profile']['city'];
			$userec->state = $user['profile']['region'];
			$userec->country = $user['profile']['country'];
			$userec->phone = $user['profile']['phone'];
			$userec->user_id = $user['id'];

			
			
                        if($input->get('task')==="register")
						{
							
							
										$userec->usergroup_id = 1;
										$userec->payment_id= 0;
									   $userec->shipping_id = 0;


										$userec->title = 0;
									
								        $result = $db->insertObject('#__jshopping_users', $userec, 'user_id');



						}
						else
							if($input->get('task')==="save")
							{
								
							    $result = $db->updateObject('#__jshopping_users', $userec, 'user_id');

							}
			
		}
		else
			if($input->get('option')==="com_jshopping")
			{
						
				$userec->user_id = $user['id'];
				
						if($input->get('task')==="registersave")
						{
							$userec->profile_key = 'profile.address1';
							$userec->profile_value=$_POST["street"];
							$userec->ordering = 1;
							$result = $db->insertObject('#__user_profiles', $userec, 'user_id');
							
								$userec->profile_key = 'profile.city';
							$userec->profile_value=$_POST["city"];
							$userec->ordering = 3;
							$result = $db->insertObject('#__user_profiles', $userec, 'user_id');
							
									$userec->profile_key = 'profile.country';
							$userec->profile_value=$_POST["country"];
							$userec->ordering = 5;
							$result = $db->insertObject('#__user_profiles', $userec, 'user_id');
							
							$userec->profile_key = 'profile.phone';
							$userec->profile_value=$_POST["phone"];
							$userec->ordering = 7;
							$result = $db->insertObject('#__user_profiles', $userec, 'user_id');
							
							$userec->profile_key = 'profile.postal_code';
							$userec->profile_value=$_POST["zip"];
							$userec->ordering = 6;
							$result = $db->insertObject('#__user_profiles', $userec, 'user_id');
							
							$userec->profile_key = 'profile.region';
							$userec->profile_value=$_POST["state"];
							$userec->ordering = 4;
							$result = $db->insertObject('#__user_profiles', $userec, 'user_id');

						}
						else
							if($input->get('task')==="accountsave")
							{

                           $query = $db->getQuery(true);
                           $query = "UPDATE `#__user_profiles` SET profile_value = '".$_POST['street']."' WHERE user_id = ".$user['id']." AND profile_key = 'profile.address1'" ;
                           $db->setQuery($query);
                           $result = $db->execute();									
												
						   $query = $db->getQuery(true);
                           $query = "UPDATE `#__user_profiles` SET profile_value = '".$_POST['city']."' WHERE user_id = ".$user['id']." AND profile_key = 'profile.city'" ;
                           $db->setQuery($query);
                           $result = $db->execute();
							
						   $query = $db->getQuery(true);
                           $query = "UPDATE `#__user_profiles` SET profile_value = '".$_POST['country']."' WHERE user_id = ".$user['id']." AND profile_key = 'profile.country'" ;
                           $db->setQuery($query);
                           $result = $db->execute();
							
										
						   $query = $db->getQuery(true);
                           $query = "UPDATE `#__user_profiles` SET profile_value = '".$_POST['phone']."' WHERE user_id = ".$user['id']." AND profile_key = 'profile.phone'" ;
                           $db->setQuery($query);
                           $result = $db->execute();
							
						   $query = $db->getQuery(true);
                           $query = "UPDATE `#__user_profiles` SET profile_value = '".$_POST['zip']."' WHERE user_id = ".$user['id']." AND profile_key = 'profile.postal_code'" ;
                           $db->setQuery($query);
                           $result = $db->execute();
							
							
							  $query = $db->getQuery(true);
                           $query = "UPDATE `#__user_profiles` SET profile_value = '".$_POST['state']."' WHERE user_id = ".$user['id']." AND profile_key = 'profile.region'" ;
                           $db->setQuery($query);
                           $result = $db->execute();
							}
			}
      endif;
		
	}
	
}