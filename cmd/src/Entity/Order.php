<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @Entity @Table(name="orders")
 */
class Order
{
    /**
     * @Id
     * @GeneratedValue()
     * @Column(type="integer")
     */
    private $number;

    /**
     * @Column(type="datetime")
     */
    private $create_datetime;

    /**
     * @OneToMany(targetEntity="Entity\OrderItem", mappedBy="order_custom")
     *
     */
    private $orderItems;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function getCreateDatetime(): ?\DateTimeInterface
    {
        return $this->create_datetime;
    }

    public function setCreateDatetime(\DateTime $create_datetime): self
    {
        $this->create_datetime = $create_datetime;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): self
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems[] = $orderItem;
            $orderItem->setOrderCustom($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): self
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->removeElement($orderItem);
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrderCustom() === $this) {
                $orderItem->setOrderCustom(null);
            }
        }

        return $this;
    }
}
