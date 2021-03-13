<?php

/**
 * @package Plugin content - addarticletojshopping for Joomla! 3.x and Joomla 4 alpha-Beta
 * @version $Id: system - zoomart 1.0.0 2021-01-12 23:26:33Z $
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
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Form\FormHelper;
use Joomla\String\StringHelper;

class PlgContentAddarticletojshopping extends CMSPlugin
{
	
	protected $autoloadLanguage = true;
	protected $db;
	
	public function onAfterInitialise()
	{
		
		$this->loadLanguage();
	}
	
	public function onContentBeforeSave($context, $article, $isNew)
	{
		$app = Factory::getApplication();
		$user = Factory::getUser();
		$articlelen= $this->params->get('articlelength');

		
		  if($app->isClient('site') && $context==='com_k2.item')
		 {
			 $lang = Factory::getLanguage();
		$ls = $lang->getTag();
		
		$data = $app->input->post->getArray();
		
			 if(empty($article->id)){
		
		

		
	$currencyid = $this->params->get('currencyid');
	$taxid = $this->params->get('taxid');
	$producttemplate = $this->params->get('producttemplate');
	$vendorid = $this->params->get('vendorid');


    
		
         $itemrec = new stdClass();	
         $itemrec->product_id = 0;
         $itemrec->product_quantity = 1;
         $itemrec->unlimited = 0;
		 $itemrec->product_ean = $article->id;
		 $itemrec->manufacturer_code = $user->id;
		 
         $itemrec->product_date_added= new DateTime($article->created); 
		 
         $itemrec->product_publish=1;
		  if(!empty($currencyid))
                $itemrec->currency_id=$currencyid;
			else
			    $itemrec->currency_id=1;

		  if(!empty($producttemplate))
                   $itemrec->product_template=$producttemplate;
		  else
		                     $itemrec->product_template='default';

		           
		 
		 
		 $itemrec->product_price=$data['K2ExtraField_1'];
		 		 $itemrec->min_price=$data['K2ExtraField_1'];
				 $itemrec->product_old_price=0.0;
				 $itemrec->product_buy_price=0.0;
		 		 $itemrec->different_prices=0;
				 $itemrec->average_rating = 0.0;
		
				 $itemrec->add_price_unit_id=1;

				 $itemrec->delivery_times_id=0;
				 $itemrec->weight_volume_units=0.0;
				 $itemrec->product_weight=0.0;
				 
				 $itemrec->basic_price_unit_id = 1;
				 
					  if(!empty($vendorid))	 
				             $itemrec->vendor_id=$vendorid;
						else
						    $itemrec->vendor_id= 1;
							
							
					  if(!empty($taxid))	 
				             $itemrec->product_tax_id=$taxid;
						else
						    $itemrec->product_tax_id= 1;
				 
				 
				 
				 $itemrec->label_id=0;
				 
            $itemrec->{"meta_keyword_".$ls} = $article->metakey;
             $itemrec->{"meta_description_".$ls} = $article->metadesc;
			 $itemrec->{"alias_".$ls}=$article->alias;

		 
		 
		 
		 $itemrec->different_prices = 0;
		 $itemrec->product_manufacturer_id = 0;
		 $itemrec->product_is_add_price = 0;
		 $itemrec->average_rating = 0;
		 $itemrec->reviews_count= 0 ;
		 $itemrec->hits = 0;
		 $itemrec->access = 1;
	
		$itemrec->{"name_".$ls}=$article->title;
	
		 $itemrec->{"short_description_".$ls}=$data['K2ExtraField_2'];	

		 		 $itemrec->{"description_".$ls}=StringHelper::substr( $article->introtext,0, $articlelen )."...";

		 
	
		 
		 $result = $this->db->insertObject('#__jshopping_products', $itemrec, 'product_id');
		 
		 if($result==1)
		 {
			 	$query = $this->db->getQuery('true');
				$query="SELECT product_id FROM #__jshopping_products Order By product_id Desc";
		        $this->db->setQuery($query);
	            $id= $this->db->loadObject();
		        $lastproductid = $id->product_id;
				
			
			 	$query = $this->db->getQuery('true');
				$query
    ->select(array('a.category_id', 'b.name'))
    ->from($this->db->quoteName('#__jshopping_categories', 'a'))
    ->join('INNER', $this->db->quoteName('#__k2_categories', 'b') . ' ON ' . $this->db->quoteName('a.name_'.$ls) . ' = ' . $this->db->quoteName('b.name'))
    ->where($this->db->quoteName('b.id') . ' LIKE ' . $this->db->quote($article->catid));
	
	$this->db->setQuery($query);
	$r = $this->db->loadObject();
	var_dump($r);
	
				 	$query = $this->db->getQuery('true');
            $columns = array('product_id', 'category_id', 'product_ordering');
            $values = array( $this->db->quote($lastproductid), $this->db->quote($r->category_id),  1);
            $query
            ->insert($this->db->quoteName('#__jshopping_products_to_categories'))
            ->columns($this->db->quoteName($columns))
            ->values(implode(',', $values));
            $this->db->setQuery($query);
            $this->db->execute();

	
		
		 }
		 


			 }else{
					$query = $this->db->getQuery('true');
				$query="SELECT product_id FROM #__jshopping_products where product_ean = ". $article->id;
		        $this->db->setQuery($query);
	            $id= $this->db->loadObject();
		        $productid = $id->product_id;
		            $itemrec = new stdClass();	
				    $itemrec->product_id = $productid;
					
					$itemrec->date_modify= new DateTime($article->modified); 

					$itemrec->product_price=$data['K2ExtraField_1'];
		 		    $itemrec->min_price=$data['K2ExtraField_1'];
				    $itemrec->{"meta_keyword_".$ls} = $article->metakey;
                    $itemrec->{"meta_description_".$ls} = $article->metadesc;
			        $itemrec->{"alias_".$ls}=$article->alias;
			    	$itemrec->{"name_".$ls}=$article->title;
	              
				  $itemrec->{"short_description_".$ls}=$data['K2ExtraField_2'];	
				  $itemrec->{"description_".$ls}=StringHelper::substr($article->introtext,0, $articlelen )."...";

					 
					 $result = $this->db->updateObject('#__jshopping_products', $itemrec, 'product_id');




		   
		   
			 }
		
			  }

		return true;
	}
	
}