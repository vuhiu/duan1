<?php

class CartController
{
    public function getCart($user_id)
    {
        echo "Hiển thị giỏ hàng của user_id: $user_id";
    }

    public function addToCart()
    {
        echo "Thêm sản phẩm vào giỏ hàng.";
    }

    public function updateCartItem()
    {
        echo "Cập nhật sản phẩm trong giỏ hàng.";
    }

    public function deleteCartItem()
    {
        echo "Xóa sản phẩm khỏi giỏ hàng.";
    }
}