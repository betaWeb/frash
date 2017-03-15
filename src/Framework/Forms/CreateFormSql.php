<?php
namespace Frash\Framework\Forms;
use Frash\Framework\DIC\Dic;

/**
 * Class CreateFormSql
 * @package Frash\Framework\Forms
 */
class CreateFormSql{
    /**
     * @var string
     */
    private $path = '';

    /**
     * CreateFormSql constructor.
     * @param string $path
     */
    public function __construct($path){
        $this->path = $path;
    }

    /**
     * @param Dic $dic
     * @param array $spec
     */
    public function create(Dic $dic, $spec = []){}
}