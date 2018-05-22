<?php
/* --------------------------------------------------------------
   NahrwertServicesAjaxHandler.inc.php 2016-05-03
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
//require_once(DIR_FS_CATALOG . 'gm/classes/JSON.php');

/**
 * Class NahrwertServicesAjaxHandler
 */
include("http://boost4u.supp4u.com/admin/NB/db.php");

	$jsondata=array_merge($_POST,$_GET);
	$data = array();
	switch($jsondata['action'])
	{
		case 'add_nahrwert':
			$data['html'] = writeData($jsondata);
			$data['html'] .= getData($jsondata);
			$data['action'] = $jsondata['action'];
			$data['tracking_code'] = json_decode(stripslashes($jsondata['tracking_code']));
			break;
		case 'delete_nahrwert':
			deleteData($jsondata);
			$data['html']= getData($jsondata);
			$data['action'] = $jsondata['action'];
			$data['tracking_code'] = json_decode(stripslashes($jsondata['tracking_code']));
			break;
		case 'add_nahrwertstandard':
			$data['html'] = writenahrwertStandard($jsondata);
			break;
	}
	
	echo json_encode($data);
//  + nutrition_dropdown+'-'+ nutrition_quantity+'-'+ nutrition_einheit+'-'+ nutriton_per_day+'-'+ nutrition_label_order
	
	function writenahrwertStandard($array)
	{
		$query ="insert into nutrition_standard_products set products_id=".$array['products_id'].",nutriton_energie='".$array['nutriton_energie']."',nutriton_energie_kj='".$array['nutriton_energie_kj']."',nutriton_protein='".$array['nutriton_protein']."',nutriton_kh='".$array['nutriton_kh']."',nutriton_kh_zucker='".$array['nutriton_kh_zucker']."',nutriton_f='".$array['nutriton_f']."',nutriton_f_gesaetigt='".$array['nutriton_f_gesaetigt']."',nutriton_ballast='".$array['nutriton_ballast']."',nutriton_salz='".$array['nutriton_salz']."',nutriton_servings='".$array['nutriton_servings']."',nutriton_serving_size='".$array['nutriton_serving_size']."' ";
		$query .=" ON DUPLICATE KEY Update  nutriton_energie='".$array['nutriton_energie']."',nutriton_energie_kj='".$array['nutriton_energie_kj']."',nutriton_protein='".$array['nutriton_protein']."',nutriton_kh='".$array['nutriton_kh']."',nutriton_kh_zucker='".$array['nutriton_kh_zucker']."',nutriton_f='".$array['nutriton_f']."',nutriton_f_gesaetigt='".$array['nutriton_f_gesaetigt']."',nutriton_ballast='".$array['nutriton_ballast']."',nutriton_salz='".$array['nutriton_salz']."',nutriton_servings='".$array['nutriton_servings']."',nutriton_serving_size='".$array['nutriton_serving_size']."' ";
		$link =	mysql_connect("rdbms.strato.de","U2367964","Bachert71") ;
		mysql_select_db("DB2367964");
		$result = mysql_query($query, $link);
		mysql_close($link);
		return $query;
	}
	function getnahrwertStandard($array)
	{
		
	}
	
	
	function deleteData($array)
	{
		$query= "delete from nutrition_products where id=".$array['id'];
		$link =	mysql_connect("rdbms.strato.de","U2367964","Bachert71") ;
		mysql_select_db("DB2367964");
		$result = mysql_query($query, $link);
		mysql_close($link);
		
		
	}
	function writeData($array)
	{
		$query= "insert into nutrition_products set products_id=".$array['products_id'].",text='".$array['nutrition_text']."', nutrition_id=".$array['nutrition_dropdown'].", mengeportion=".$array['nutrition_quantity'].", sort_order=".$array['nutrition_label_order'].",eingerueckt=".$array['nutrition_eingerueckt'];
		$link =	mysql_connect("rdbms.strato.de","U2367964","Bachert71") ;
		mysql_select_db("DB2367964");
		$result = mysql_query($query, $link);
		mysql_close($link);
		return  $query;

	}
	
	function getData($array)
	{
		$html="";
		$link2 =	mysql_connect("rdbms.strato.de","U2367964","Bachert71") ;
		mysql_select_db("DB2367964");
		$query = "Select np.*,n.nahrstoffde from nutrition_products np left join nutrition n ON n.nutrition_id=np.nutrition_id where products_id=".$array['products_id']." order by sort_order";
		$result = mysql_query($query, $link2);
		while($nutrition_row = mysql_fetch_array($result)) {
			$html .="<tr><td style='width:120px'>".$nutrition_row['nahrstoffde'].$nutrition_row['text']." (".$nutrition_row['nutrition_id'].")</td><td>".$nutrition_row['mengeportion']."</td><td style='width:120px'>Einheit".$nutrition_row['mengeportion']."</td><td>%</td><td>sortorder ".$nutrition_row['sort_order']."</td><td>eingerückt".$nutrition_row['eingerueckt']."</td><td><span class='btn-delete cursor-pointer delete_nahrwert' data-nahrwert_modal_layer-action='delete_nahrwert_code'  data-nahrwert_modal_layer-products_id='".$nutrition_row['products_id']."'  data-nahrwert_modal_layer-id='".$nutrition_row['id']."'  data-nahrwert_modal_layer-page_token=''>	<i class='a fa-trash-o'></i></span></td></tr>";
		//	$html .= "<tr><td>".$nutrition_row['nutrition_id']."</td><td>".$nutrition_row['mengeportion']."</td><td>".$nutrition_row['menge100g']."</td><td>".$nutrition_row['menge100g']."</td><td>".$nutrition_row['sort_order']."</td><td><span class='btn-delete cursor-pointer delete_nahrwert' data-nahrwert_modal_layer-action='delete_nahrwert_code'  data-nahrwert_modal_layer-products_id='".$nutrition_row['products_id']."'  data-nahrwert_modal_layer-id='".$nutrition_row['id']."'  data-nahrwert_modal_layer-page_token=''>	<i class='a fa-trash-o'></i></span></td></tr>";  
		//	 $nutrition_array[$nutrition_row['nutrition_id']] = $nutrition_row['nahrstoffde'];
		}
		mysql_close($link2); 
		return $html; 

	}
	
