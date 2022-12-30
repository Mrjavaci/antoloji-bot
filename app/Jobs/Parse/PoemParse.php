<?php

namespace App\Jobs\Parse;

use App\Contracts\ParseInterface;

class PoemParse implements ParseInterface
{
    private $title;
    private $body;
    private $writer;
    private $isOwnPoemOfUser;

    private $isSuccess = true;

    public function __construct(private $data)
    {

    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getWriter()
    {
        return $this->writer;
    }

    /**
     * @param mixed $writer
     */
    public function setWriter($writer): void
    {
        $this->writer = $writer;
    }

    /**
     * @return mixed
     */
    public function getIsOwnPoemOfUser()
    {
        return $this->isOwnPoemOfUser;
    }

    /**
     * @param mixed $isOwnPoemOfUser
     */
    public function setIsOwnPoemOfUser($isOwnPoemOfUser): void
    {
        $this->isOwnPoemOfUser = $isOwnPoemOfUser;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * @param bool $isSuccess
     */
    public function setIsSuccess(bool $isSuccess): void
    {
        $this->isSuccess = $isSuccess;
    }

    public function parse(): self
    {
        $this->title = $this->parseTitle();
        $this->body = $this->parseBody();
        $this->writer = $this->parseWriter();
        if (empty($this->title) || empty($this->body) || empty($this->writer)) {
            $this->isSuccess = false;
            return $this;
        }
        $this->isOwnPoemOfUser = str_contains($this->body, 'Kayıt Tarihi');
        return $this;
    }

    protected function parseTitle()
    {
        preg_match_all('/"pd-title-a">[\s\S]*<h3>(.*?)<\/h3>/m', $this->getData(), $matches, PREG_SET_ORDER, 0);
        return $this->processString($matches[0][1] ?? null);
    }

    public function getData()
    {
        return $this->data;
    }

    protected function processString($str)
    {
        return mb_convert_encoding(rtrim(ltrim(strip_tags($str))),'UTF-8');
    }

    protected function parseBody()
    {
        preg_match_all('/pd-text">(.*?)<div class="poem-rank">/s', $this->getData(), $matches, PREG_SET_ORDER, 0);
        return $this->processString($matches[0][1] ?? null);
    }

    private function parseWriter()
    {
        preg_match_all('/pb-title">(.*?)<\/a>/s', $this->getData(), $matches, PREG_SET_ORDER, 0);
        return $this->processString($matches[0][1] ?? null);
    }

    public function setData($data): void
    {
        $this->data = $data;
    }
}
