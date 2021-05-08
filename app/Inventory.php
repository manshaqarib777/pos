<?php
namespace App;

class Inventory
{
    private $products = null;
    private $totalQty = 0;
    private $totalCost = 0;
    public function __construct($oldInventory)
    {
        if ($oldInventory) {
            $this->products = $oldInventory->products;
            $this->totalQty = $oldInventory->totalQty;
            $this->totalCost = $oldInventory->totalCost;
        }
    }
    public function add($product, $itemId)
    {
        $purchaseProduct = array(
        'id'=>$itemId,
        'qty'=>'0',
        'cost'=> $product->cost,
        'subTotal'=>'0',
        'product'=>$product
        );
        if ($this->products && array_key_exists($itemId, $this->products)) {
                $purchaseProduct = $this->products[$itemId];
        }
        $purchaseProduct['qty']++;
        $purchaseProduct['subTotal'] = $product->cost * $purchaseProduct['qty'];
        $this->products[$itemId] = $purchaseProduct;
        $this->totalQty++;
        $this->totalCost += $product->cost;
    }
    public function getProducts()
    {
        return $this->products;
    }
    public function getTotal()
    {
        return $this->totalCost;
    }
    public function getTotalQty()
    {
        return $this->totalQty;
    }
    public function remove($id)
    {
        $this->totalQty -=$this->products[$id]['qty'];
        $cost = $this->products[$id]['cost']*$this->products[$id]['qty'];
        $this->totalCost -=$cost;
        unset($this->products[$id]);
    }
    public function qtyChange($itemId, $quantity)
    {
        $this->totalQty -= $this->products[$itemId]['qty'];
        $this->totalCost -= $this->products[$itemId]['subTotal'];
        $this->products[$itemId]['qty'] = $quantity;
        $this->products[$itemId]['subTotal'] = $quantity * $this->products[$itemId]['cost'];
        $this->totalQty += $quantity;
        $this->totalCost += $quantity * $this->products[$itemId]['cost'];
    }
}
