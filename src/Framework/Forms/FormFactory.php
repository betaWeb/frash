<?php
namespace Frash\Framework\Forms;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Forms\{ CreateForm, CreateFormSql, VerifForm };

/**
 * Class FormFactory
 * @package Frash\Framework\Forms
 */
class FormFactory{
    const PATH = 'Frash\\Framework\\Forms\\Type\\';

    /**
     * @var Dic
     */
    private $dic;

    /**
     * FormFactory constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
    }

    /**
     * @return \Frash\Framework\Forms\VerifForm
     */
    public function verif(){
        return new VerifForm($this->dic);
    }

    /**
     * @return \Frash\Framework\Forms\CreateForm
     */
    public function create(){
        return new CreateForm(self::PATH, $this->dic);
    }

    /**
     * @return \Frash\Framework\Forms\CreateFormSql
     */
    public function createSql(){
        return new CreateFormSql(self::PATH, $this->dic);
    }

    /**
     * @return object
     */
    public function getPost(){
        return (object) $_POST;
    }
}