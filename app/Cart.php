<?php

namespace App;



class Cart{
	public $tbl_product = null;
	public $totalPrice = 0;
	public $totalQuanty = 0;

	public function __construct($cart){
		if($cart){
			$this->tbl_product    = $cart->tbl_product;
			$this->totalPrice  = $cart->totalPrice;
			$this->totalQuanty = $cart->totalQuanty;
		}
	}

	public function AddCart($product, $id){
		$newProduct = ['quanty' => 0, 'product_price' => $product->product_price, 'productInfo' => $product];
		$pro = $this->tbl_product;
		if($pro){
			if(array_key_exists($id, $pro)){
				$newProduct = $this->$tbl_product[$id];
			}
		}
		$newProduct['quanty']++;
		$newProduct['product_price'] = $newProduct['quanty'] * $product->product_price;
		$this->tbl_product[$id] = $newProduct;
		$this->totalPrice  += $product->product_price;
		$this->totalQuanty++;
	}

}

?>