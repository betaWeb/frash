<?php
    namespace Composants\Framework\Mail;
    use Composants\Framework\Exception\InitMailFail;

    class Mailer{
        private $body;
        private $mail;
        private $title;

        public function init($array){
            if(empty($array['mail'])){ return new InitMailFail('L\'adresse mail n\'est pas indiquée.'); }
            if(empty($array['title'])){ return new InitMailFail('Le sujet du mail n\'est pas indiqué.'); }
            if(empty($array['body'])){ return new InitMailFail('Le corps du mail n\'est pas indiqué.'); }

            $this->body = $array['body'];
            $this->mail = $array['mail'];
            $this->title = $array['title'];
        }

        public function sendSimple(){
            mail($this->mail, $this->title, $this->body);
        }

        public function sendComplex(){}
    }