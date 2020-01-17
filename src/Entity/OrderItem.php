<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 * @ORM\Table(name="order_items")
 */
class OrderItem
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false,
     *     name="order_customs", referencedColumnName="number")
     */
    private $order_custom;

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=30, options={"fixed" = true})
     */
    private $product_name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $product_price;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;


    public function getOrderCustom(): ?Order
    {
        return $this->order_custom;
    }

    public function setOrderCustom(?Order $order_custom): self
    {
        $this->order_custom = $order_custom;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): self
    {
        $this->product_name = $product_name;

        return $this;
    }

    public function getProductPrice(): ?string
    {
        return $this->product_price;
    }

    public function setProductPrice(string $product_price): self
    {
        $this->product_price = $product_price;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
