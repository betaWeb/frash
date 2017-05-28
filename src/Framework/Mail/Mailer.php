<?php
namespace Frash\Framework\Mail;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Exception\Exception;

/**
 * Class Mailer
 * @package Frash\Framework\Mail
 */
class Mailer{
    /**
     * @var string
     */
    private $body;

    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var string
     */
    private $title;

    /**
     * Mailer constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
    }

    /**
     * @param array $array
     * @return Exception
     */
    public function init($array){
        if(empty($array['mail'])){ return $this->dic->load('exception')->publish('Mailer : L\'adresse mail n\'est pas indiquée.'); }
        if(empty($array['title'])){ return $this->dic->load('exception')->publish('Mailer : Le sujet du mail n\'est pas indiqué.'); }
        if(empty($array['body'])){ return $this->dic->load('exception')->publish('Mailer : Le corps du mail n\'est pas indiqué.'); }

        $this->body = $array['body'];
        $this->mail = $array['mail'];
        $this->title = $array['title'];
    }

    /**
     * @return bool
     */
    public function sendSimple(): bool
    {
        if(mail($this->mail, $this->title, $this->body)){
            return true;
        } else {
            return false;
        }
    }

    public function sendComplex(){}
}