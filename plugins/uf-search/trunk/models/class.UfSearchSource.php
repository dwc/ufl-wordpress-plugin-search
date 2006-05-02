<?php
if (! class_exists('UfNewsSearchSource')) {
	class UfNewsSearchSource {
		var $name;
		var $url;
		var $parameter;

		function UfNewsSearchSource($theName, $theUrl, $theParameter) {
			$this->name = $theName;
			$this->url = $theUrl;
			$this->parameter = $theParameter;
		}

		function search($query) {
			header('Location: ' . $this->url . '?' . $this->parameter . '=' . urlencode($query));
		}
	}
}
?>
