<?php

namespace App;

class Cart
{
    private $products = null ;
    private $totalQty = 0;
    private $totalPrice = 0;


    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->products = $oldCart->products;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }


    public function add($product, $id)
    {
        $storeProduct = array(
            'id'=>$id,
            'qty'=>0,
            'price'=> $product->price,
            'subTotal'=>0,
            'discount'=>0,
            'product'=>$product
        );
        if ($this->products && array_key_exists($id, $this->products)) {
                $storeProduct = $this->products[$id];
        }
        $storeProduct['qty']++;
        $storeProduct['subTotal'] = $product->price * $storeProduct['qty'];
        $this->products[$id] = $storeProduct;
        $this->totalQty++;
        $this->totalPrice += $product->price;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function getTotal()
    {
        return $this->totalPrice;
    }

    public function getTotalQty()
    {
        return $this->totalQty;
    }

    public function remove($id)
    {
        $this->totalQty -=$this->products[$id]['qty'];
        $price = $this->products[$id]['price']*$this->products[$id]['qty'];
        $this->totalPrice -=$price;
        unset($this->products[$id]);
    }

    public function qtyChange($id, $qty)
    {
        $this->totalQty -= $this->products[$id]['qty'];
        $this->totalPrice -= $this->products[$id]['subTotal'];
        $this->products[$id]['qty'] = $qty;
        $this->products[$id]['subTotal'] = $qty*$this->products[$id]['price'];
        $this->totalQty += $qty;
        $this->totalPrice += $qty*$this->products[$id]['price'];
    }

    public function update($item)
    {
        $this->totalQty -= $this->products[$item['id']]['qty'];
        $this->totalPrice -= $this->products[$item['id']]['subTotal'];
        unset($this->products[$item['id']]);
        $storeProduct = array(
        'id'       => $item['id'],
        'qty'      => 0,
        'price'    => $item['price'],
        'subTotal' => 0,
        'discount' => 0,
        'name'     => $item['name'],
        'product'  => $item
        );
        $storeProduct['qty'] = $item['qty'];
        $storeProduct['discount'] = $item['discount_amount'];
        $storeProduct['subTotal'] = ($storeProduct['price'] * $item['qty']) - $item['discount_amount'];
        $this->products[$item['id']] = $storeProduct;
        $this->totalQty += $item['qty'];
        $this->totalPrice += $storeProduct['subTotal'];
    }
}
