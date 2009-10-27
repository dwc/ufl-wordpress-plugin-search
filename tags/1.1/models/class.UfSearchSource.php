<?php
if (! class_exists('UfSearchSource')) {
	class UfSearchSource {
		var $name;
		var $url;
		var $parameter;

		function UfSearchSource($name, $url, $parameter) {
			$this->name = $name;
			$this->url = $url;
			$this->parameter = $parameter;
		}

		function search($query) {
			header('Location: ' . $this->url . '?' . $this->parameter . '=' . urlencode($query));
		}
	}
}
?>
