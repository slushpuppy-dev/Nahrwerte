<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 class NahrwertClass extends ContentView{
	protected $_html; 
	protected $products_id;
	protected $PageToken;
	 
	public function __construct()
	{
		$this->set_template_dir(DIR_FS_CATALOG . 'admin/html/content/nahrwert/');
		$this->set_content_template('nahrwert.html');
		$this->_html = "STARTWERTE OHNE Zusammenhang";

	}
	 
	public function get_data($pID)
	{
		$this->products_id = $pID;
		$this->PageToken = $t_page_token;
		$this->getAllNutrient();
		$this->getEinheit(); 
		
		$this->set_content_data('products_id', $pID);
		$this->set_content_data('page_token', $this->PageToken);
	}
	Public function getEinheit()
	{
		$einheit_option_array[0]='';
		$einheit_option_array[1]='kg';
		$einheit_option_array[2]='g';
		$einheit_option_array[3]='mg';
		$einheit_option_array[4]='ug';
		
		$selected=2;
		
		$this->set_content_data('einheit_options_selected', $selected);
		$this->set_content_data('einheit_options',$einheit_option_array);
	}
	Public function getAllNutrient()
	{
		
		$nutrition_standard_query = xtc_db_query("Select * from nutrition_standard_products where products_id=".$this->products_id);
		$nutrition_standard_row = xtc_db_fetch_array($nutrition_standard_query);
		
		$this->set_content_data('nutriton_energie', $nutrition_standard_row['nutriton_energie']);
		$this->set_content_data('nutriton_energie_kj', $nutrition_standard_row['nutriton_energie_kj']);
		$this->set_content_data('nutriton_protein', $nutrition_standard_row['nutriton_protein']);
		$this->set_content_data('nutriton_kh', $nutrition_standard_row['nutriton_kh']);
		$this->set_content_data('nutriton_kh_zucker', $nutrition_standard_row['nutriton_kh_zucker']);
		$this->set_content_data('nutriton_f', $nutrition_standard_row['nutriton_f']);
		$this->set_content_data('nutriton_f_gesaetigt', $nutrition_standard_row['nutriton_f_gesaetigt']);
		$this->set_content_data('nutriton_ballast', $nutrition_standard_row['nutriton_ballast']);
		$this->set_content_data('nutriton_salz', $nutrition_standard_row['nutriton_salz']);
		$this->set_content_data('nutriton_serving_size', $nutrition_standard_row['nutriton_serving_size']);
		$this->set_content_data('nutriton_servings', $nutrition_standard_row['nutriton_servings']);
		
		$selected='';
		$nutrition_query = xtc_db_query("Select nutrition_id, nahrstoffde from nutrition where aktiv=1 and nahrstoffde !='' order by nahrstoffde");
		$nutrition_options['999999'] = 'Sonstiges';
		while($nutrition_row = xtc_db_fetch_array($nutrition_query)) {
			if($selected==''){$selected=$nutrition_row['nutrition_id'];}
			$nutrition_options[$nutrition_row['nutrition_id']] = $nutrition_row['nahrstoffde'];
		}
		//$query = "Select * from nutrition_products where products_id=".$this->products_id;
		$query = "Select np.*,n.nahrstoffde from nutrition_products np left join nutrition n ON n.nutrition_id=np.nutrition_id where products_id=".$this->products_id." order by sort_order";
		$nutrition_products_query = xtc_db_query($query);
		//echo xtc_db_num_rows($nutrition_products_query);

		while($nutrition_product_row = xtc_db_fetch_array($nutrition_products_query)) {
			$nutrition_array[$nutrition_product_row['id']] = array('nutrition_id'=>$nutrition_product_row['nutrition_id'],
															'products_id'=>$nutrition_product_row['products_id'],
															'id_oberelement'=>$nutrition_product_row['id_oberelement'],
															'mengeportion'=>$nutrition_product_row['mengeportion'],
															'menge100g'=>$nutrition_product_row['menge100g'],
															'intabelle'=>$nutrition_product_row['intabelle'],
															'text'=>$nutrition_product_row['text'],
															'sort_order'=>$nutrition_product_row['sort_order'],
															'eingerueckt'=>$nutrition_product_row['eingerueckt'],
															'nahrstoffde'=>$nutrition_product_row['nahrstoffde'],
															'id'=>$nutrition_product_row['id']);
		//	echo"1";
		}
		//print_r($nutrition_array);
		$this->set_content_data('nutrition_standard',nutrition_standard_row);
		$this->set_content_data('nutrition_array',$nutrition_array);
		$this->set_content_data('nutrition_options_selected', $selected);
		$this->set_content_data('nutrition_options',$nutrition_options);
		$this->set_content_data('test',$this->_html);
		
	}
 }
