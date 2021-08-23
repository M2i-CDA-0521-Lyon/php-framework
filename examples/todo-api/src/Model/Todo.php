<?php

namespace App\Model;

use Cda0521Framework\Database\Sql\Table;
use Cda0521Framework\Database\Sql\Column;
use Cda0521Framework\Database\AbstractModel;

#[Table('todo')]
class Todo extends AbstractModel
{
    protected ?int $id;
    #[Column('text')]
    protected string $text;
    #[Column('done')]
    protected bool $done;

    public function __construct(?int $id = null, string $text = '', bool $done = false)
    {
        $this->id = $id;
        $this->text = $text;
        $this->done = $done;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of text
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of done
     */ 
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set the value of done
     *
     * @return  self
     */ 
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }
}
