<?php
namespace Entities;

/**
 * @Entity @Table(name="words")
 * @Entity @Table(name="words",indexes={@Index(name="word", columns={"word"})})
 **/
class Word
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $word;

    public function getId()
    {
        return $this->id;
    }

    public function getWord()
    {
        return $this->word;
    }

    public function setWord($word)
    {
        $this->word = $word;
    }
}