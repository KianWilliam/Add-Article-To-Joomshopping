<?php

/**
 * @package Plugin content - addarticletojshopping for Joomla! 3.x and Joomla 4 alpha-Beta
 * @version $Id: system - zoomart 1.0.0 2021-03-15 23:26:33Z $
 * @author KWProductions Co.
 * @(C) 2020-2025.Kian William Productions Co. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of content - addarticletojshopping.
    content - addarticletojshopping is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    plugin content - addarticletojshopping is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with content - addarticletojshopping.  If not, see <http://www.gnu.org/licenses/>.
 
**/

?>

<?php 
defined('_JEXEC') or die;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;

class PlgUserAddUserFolderToJce extends CMSPlugin
{
	
	public function onUserAfterSave($user, $isnew, $success, $msg)
	{
		
		if($isnew)
		{
			$result = Folder::create(JPATH_ROOT.'\\images\\'. $user["username"], 755);
			
		}
	}
	public function onUserAfterDelete($user, $success, $msg)
	{
		if(Folder::exists(JPATH_ROOT.'\\images\\'. $user["username"]))
		{
			Folder::delete(JPATH_ROOT.'\\images\\'. $user["username"]);
		}
	}
	
}