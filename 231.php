<?php
function test(Strong $a, $b = '',$c = '') {
	$a->hello();
}
class Strong {
	public static function hello() {
		echo 'hello';
	}
	public function __construct() {
		
	}
	public static function create() {
		return new self();
	} 
}
$a = new ReflectionFunction('test');
$param = [];
foreach($a->getParameters() as $item ) {
	if($item->getType() ?? false) {
		
	$param[] = $item->getType()->getName()::create();

	}
}

call_user_func_array('test', $param );