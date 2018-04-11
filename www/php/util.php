<?php
class Util{
	public function render($viewname, $args=array()){
		Flight::render($viewname.".php",$args,'body_content');
		Flight::render('layout');
	}
}
