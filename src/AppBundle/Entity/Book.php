<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookRepository")
 */
class Book
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Название Книги
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", options={"comment": "Название Книги"})
     */
    private $name;

    /**
     * Автор
     *
     * @var string
     *
     * @ORM\Column(name="author", type="string", options={"comment": "Автор"})
     */
    private $author;


    /**
     * Обложка
     *
     * @var string
     *
     * @ORM\Column(name="cover", type="string",nullable=true, options={"comment": "Обложка"})
     */
    private $cover;

    /**
     * Файл книги
     *
     * @var string
     *
     * @ORM\Column(name="file_book", type="string", nullable=true, options={"comment": "Файл книги"})
     */
    private $fileBook;

    /**
     * Дата прочтения
     * @var \DateTime
     * @ORM\Column(name="read_date", type="datetime", nullable=true, options={"comment": "Дата прочтения"})
     */
    private $readDate;


    /**
     * Признак того, что книгу можно скачать
     * @var string
     * @ORM\Column(name="is_downloaded", type="boolean", nullable=true, options={"default": false, "comment": "Признак того, что книгу можно скачать"})
     */
    private $isDownloaded;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return string
     */
    public function getFileBook()
    {
        return $this->fileBook;
    }

    /**
     * @param string $fileBook
     */
    public function setFileBook($fileBook)
    {
        $this->fileBook = $fileBook;
    }

    /**
     * @return \DateTime
     */
    public function getReadDate()
    {
        return $this->readDate;
    }

    /**
     * @param \DateTime $readDate
     */
    public function setReadDate($readDate)
    {
        $this->readDate = $readDate;
    }

    /**
     * @return string
     */
    public function getIsDownloaded()
    {
        return $this->isDownloaded;
    }

    /**
     * @param string $isDownloaded
     */
    public function setIsDownloaded($isDownloaded)
    {
        $this->isDownloaded = $isDownloaded;
    }


}

