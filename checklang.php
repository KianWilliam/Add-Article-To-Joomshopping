<?php

/**
 * @package Plugin content - checklang for Joomla! 3.x and Joomla 4 alpha-Beta
 * @version $Id: content - checklang 1.0.0 2021-03-15 23:26:33Z $
 * @author KWProductions Co.
 * @(C) 2020-2025.Kian William Productions Co. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of content - checklang.
    content - checklang is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    plugin content - checklang is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with content - checklang.  If not, see <http://www.gnu.org/licenses/>.
 
**/

?>

<?php 
defined('_JEXEC') or die;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;



class PlgContentChecklang extends CMSPlugin
{
	
	protected $autoloadLanguage = true;
	protected $db;
	
	public function onAfterInitialise()
	{
		
		$this->loadLanguage();
	}
	
	public function onContentAfterSave($context, $article, $isNew)
	{
		$app = Factory::getApplication();
		$db = $this->db;
        $lang = Factory::getLanguage()->getTag();

		  if($app->isClient('site') && $context==='com_k2.item')
		 {
	
		$query = $db->getQuery("true");
		$query->select("*")->from($db->quoteName("#__k2_items"))->where("id =" .$article->id);
		$db->setQuery($query);
		$result = $db->loadObject();
		
	
		if($result->language === "*")
		{
		
			$itemrec = new stdClass();	
			$itemrec->language = $lang;
			$itemrec->id = $article->id;					 
			$result = $db->updateObject('#__k2_items', $itemrec, 'id');
			
		}
			
		

		   
		   
			 }
		
			  

		return true;
	}
	
}