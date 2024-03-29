<?php

namespace application\models;

use application\core\Model;

class Cart extends Model
{

    public function getProducts()
    {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    public function getTotalPrice($products)
    {
        $productsInCart = $this->getProducts();

        $total = 0;

        if ($productsInCart) {
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id']];
            }
        }
        // debug($total);
        return $total;
    }

    public function addProduct($id)
    {
        $id = intval($id);
        $productsInCart = array();

        if (isset($_SESSION['products'])) {
            // То заполним наш массив товарами
            $productsInCart = $_SESSION['products'];
        }

        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id]++;
        } else {
            // Добавляем нового товара в корзину
            $productsInCart[$id] = 1;
        }

        $_SESSION['products'] = $productsInCart;

        return self::countItems();
    }

    public function deleteProduct($id)
    {
        $id = intval($id);
        $productsInCart = array();

        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }

        unset($productsInCart[$id]);

        $_SESSION['products'] = $productsInCart;
        return self::countItems();
    }

    public static function countItems()
    {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }

    public function clear()
    {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }
}
