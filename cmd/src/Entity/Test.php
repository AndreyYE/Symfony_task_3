<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 13.01.2020
 * Time: 13:42
 */
namespace Entity;

/**
 * @Entity @Table(name="tests")
 **/

class Test
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /** @Column(type="string") **/
    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}