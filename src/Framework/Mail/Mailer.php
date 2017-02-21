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

    public function __construct(Dic $dic){
        $this->dic = $dic;
    }

    /**
     * @param array $array
     * @return Exception
     */
    public function init($array){
        if(empty($array['mail'])){ return new Exception('Mailer : L\'adresse mail n\'est pas indiquée.', $this->dic->get('conf')['config']['log']); }
        if(empty($array['title'])){ return new Exception('Mailer : Le sujet du mail n\'est pas indiqué.', $this->dic->get('conf')['config']['log']); }
        if(empty($array['body'])){ return new Exception('Mailer : Le corps du mail n\'est pas indiqué.', $this->dic->get('conf')['config']['log']); }

        $this->body = $array['body'];
        $this->mail = $array['mail'];
        $this->title = $array['title'];
    }

    public function sendSimple(){
        mail($this->mail, $this->title, $this->body);
    }

    public function sendComplex(){}
}