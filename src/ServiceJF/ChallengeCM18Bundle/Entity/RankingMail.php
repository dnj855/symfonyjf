<?php
/**
 * User: cedriclangroth
 * Date: 24/06/2018
 * Time: 16:08
 */

namespace ServiceJF\ChallengeCM18Bundle\Entity;


class RankingMail
{
    private $firstTitle;

    private $secondTitle;

    private $thirdTitle;

    private $lastTitle;

    private $defaultTitle;

    private $title;

    private $email;

    private $player;

    private $beginningContent;

    private $endingContent;

    private $games;

    private $subject;

    public function __construct($games)
    {
        $this->games = $games;
    }

    /**
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param mixed $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }

    /**
     * @return mixed
     */
    public function getLastTitle()
    {
        return $this->lastTitle;
    }

    /**
     * @param mixed $lastTitle
     */
    public function setLastTitle($lastTitle)
    {
        $this->lastTitle = $lastTitle;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
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
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstTitle()
    {
        return $this->firstTitle;
    }

    /**
     * @param mixed $firstTitle
     */
    public function setFirstTitle($firstTitle)
    {
        $this->firstTitle = $firstTitle;
    }

    /**
     * @return mixed
     */
    public function getSecondTitle()
    {
        return $this->secondTitle;
    }

    /**
     * @param mixed $secondTitle
     */
    public function setSecondTitle($secondTitle)
    {
        $this->secondTitle = $secondTitle;
    }

    /**
     * @return mixed
     */
    public function getThirdTitle()
    {
        return $this->thirdTitle;
    }

    /**
     * @param mixed $thirdTitle
     */
    public function setThirdTitle($thirdTitle)
    {
        $this->thirdTitle = $thirdTitle;
    }

    /**
     * @return mixed
     */
    public function getDefaultTitle()
    {
        return $this->defaultTitle;
    }

    /**
     * @param mixed $defaultTitle
     */
    public function setDefaultTitle($defaultTitle)
    {
        $this->defaultTitle = $defaultTitle;
    }

    /**
     * @return mixed
     */
    public function getBeginningContent()
    {
        return $this->beginningContent;
    }

    /**
     * @param mixed $beginningContent
     */
    public function setBeginningContent($beginningContent)
    {
        $this->beginningContent = $beginningContent;
    }

    /**
     * @return mixed
     */
    public function getEndingContent()
    {
        return $this->endingContent;
    }

    /**
     * @param mixed $endingContent
     */
    public function setEndingContent($endingContent)
    {
        $this->endingContent = $endingContent;
    }

    /**
     * @return mixed
     */
    public function getGames()
    {
        return $this->games;
    }

    /**
     * @param mixed $games
     */
    public function setGames($games)
    {
        $this->games = $games;
    }
}