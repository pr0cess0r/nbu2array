<?php
define('PATH_PHPQUERY', '/usr/lib/phpquery/phpQuery.php'); 
define('SITE_URL', 'http://bank.gov.ua/control/uk/curmetal/detail/currency?period=daily');
require(PATH_PHPQUERY);

class Exchange {
	public $curr = array();
	
	function __construct() {
		phpQuery::newDocument(file_get_contents(SITE_URL));
		$table = pq('td.secondColl > div.content > table')->eq(3);
		$tr = pq('tr:gt(0)', $table);
		foreach($tr as $row) {
			$td =pq('td', $row); 
			$k = $td->eq(1)->text();
			$this->curr[$k]['count'] = $td->eq(2)->text();
			$this->curr[$k]['name'] = $td->eq(3)->text();
			$this->curr[$k]['exchange'] = $td->eq(4)->text();
		}
	}
	
	function get($k) {
		return $this->curr[$k];
	}
	
	function getAll() {
		return $this->curr;
	}
}
//Example
$ex = new Exchange();
print_r( $ex->getAll() );
print_r( $ex->get('EUR') );
?>
