<?php

class Shopping
{
	var $item = "コンピュータ";
	var $price = 99800;

	function getTotal()
	{
		$tax = $this->price * 0.05;
		return $this->price + $tax;
	}
}

$result = new Shopping();
$item = $result->item;
print("$item の会計は".$result->getTotal()."円になります\n");

?>