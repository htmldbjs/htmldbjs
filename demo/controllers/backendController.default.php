<?php
/**
 * CONTROLLER BACKEND
 * Controller object
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

class backendController {

	private $controller = 'backend';
	private $parameters = array();
    private $errorCount = 0;
    private $lastError = '';
    private $lastMessage = '';
    private $pageName = '';
	
	public function __construct() {

		loadLanguageFile($this->controller);

    }
		
	public function index($parameters = NULL, $method = '') {

		$this->parameters = $parameters;

		if ('selectors' == $method) {
			$this->pageName = '';
			return $this->listSelectors();
		} else if ('blocks' == $method) {
			$this->pageName = '';
			return $this->listBlocks();
		} else if ('submit' == $method) {
			$this->pageName = '';
			return $this->submitBlock();
		} else if ('noop' == $method) {
			return;
		} else {

			$this->pageName = $method;
			if (count($this->parameters) > 0) {

				if ('selectors' == $this->parameters[0]) {
					array_shift($this->parameters);
					return $this->listSelectors();
				} else if ('blocks' == $this->parameters[0]) {
					array_shift($this->parameters);
					return $this->listBlocks();
				} else if ('submit' == $this->parameters[0]) {
					array_shift($this->parameters);
					return $this->submitBlock();
				} else if ('noop' == $this->parameters[0]) {
					return;
				} // if ('selectors' == $parameters[0]) {

			} // if (count($parameters) > 0) {

		} // if ('selectors' == $method) {

	}

	private function listSelectors() {

		$selectors = array();

		switch ($this->pageName) {
			default:
			break;

		} // switch ($this->pageName) {

		// Eliminate Dublicates
		$selectors = array_flip($selectors);
		$selectors = array_keys($selectors);

		$this->printOutput($selectors);

	}

	private function listBlocks() {

		$blocks = array();
		$selectors = isset($_REQUEST['selectors'])
				? htmlspecialchars($_REQUEST['selectors'])
				: '';
		$senderURL = isset($_REQUEST['senderURL'])
				? htmlspecialchars($_REQUEST['senderURL'])
				: '';
		$selectorList = explode("\n", $selectors);
		$selectorKeys = array_flip($selectorList);

		includeLibrary('getAllCachedObjects');
		includeLibrary('getExpressionVariableValue');

		switch ($this->pageName) {
			default:
			break;

		} // switch ($this->pageName) {

		$this->printOutput($blocks);

	}

	private function submitBlock() {

		$response = array();
		$guid = isset($this->parameters[0])
				? $this->parameters[0]
				: '';

		switch ($this->pageName) {
			default:
			break;

		} // switch ($this->pageName) {

		$this->printOutput($response);

	}

	private function printOutput($values) {
		echo base64_encode(gzcompress(rawurlencode(json_encode($values)),9));
	}

}
?>