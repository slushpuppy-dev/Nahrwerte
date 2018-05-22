<?php
/* --------------------------------------------------------------
   SampleExtender.inc.php 2016-02-23
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
//TESTING
/**
 * Class SampleExtender
 * 
 * This is a sample overload for the AdminEditProductExtenderComponent.
 * 
 * @see AdminEditProductExtenderComponent
 */
class S4U extends S4U_parent
{
	/**
	 * Overloaded "proceed" method. 
	 */
	public function proceed()
	{
		parent::proceed();
		
		require_once(DIR_FS_ADMIN . 'includes/modules/nahrwert/nahrwert.inc.php');
		require_once(DIR_FS_ADMIN . 'includes/modules/bestandextern/bestandextern.inc.php');
		require_once(DIR_FS_ADMIN . 'includes/modules/chargemhd/chargemhd.inc.php');
			
		$nahrwert = new NahrwertClass();
		$html = $nahrwert->get_data((int)$_GET['pID']);

		$bestand = new BestandExternClass();
		$html2 = $bestand->get_data((int)$_GET['pID']);
		
		$charge = new ChargeMhdClass();
		$html3 = $charge->getdata((int)$_GET['pID']);
	
		$this->v_output_buffer['top']['sample'] = array('title' => 'S4U', 'content' => $nahrwert->get_html().$bestand->get_html().$charge->get_html());
		$this->v_output_buffer['bottom']['sample'] = array('title' => 'S4UBOTTOM Headline', 'content' => 'Bottom content');
	}
}