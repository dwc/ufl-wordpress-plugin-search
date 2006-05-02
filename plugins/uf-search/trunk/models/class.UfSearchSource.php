<?php
if (! class_exists('UfSearchSource')) {
	class UfSearchSource {
		var $name;
		var $url;
		var $parameter;

		function UfSearchSource($theName, $theUrl, $theParameter) {
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
