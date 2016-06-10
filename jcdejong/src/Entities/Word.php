<?php
namespace Entities;

/**
 * @Entity @Table(name="words")
 * @Entity @Table(name="words",indexes={@Index(name="word", columns={"word", "language"})})
 **/
class Word
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string", length=25, options={"fixed" = true}, columnDefinition="NOT NULL") **/
    protected $language;

    /** @Column(type="string", length=50, options={"fixed" = true}, columnDefinition="NOT NULL") **/
    protected $word;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param string $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }
}