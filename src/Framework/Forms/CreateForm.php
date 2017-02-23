<?php
namespace Frash\Framework\Forms;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Forms\Type\{ Input, Select, StartForm, Textarea };

/**
 * Class CreateForm
 * @package Frash\Framework\Forms
 */
class CreateForm{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var string
     */
    private $path = '';

    /**
     * CreateForm constructor.
     * @param string $path
     * @param Dic $dic
     */
    public function __construct(string $path, Dic $dic){
        $this->dic = $dic;
        $this->path = $path;
    }

    /**
     * @param string $type_form
     * @param array $params
     * @return string
     */
    public function __call(string $type_form, array $params): string{
        if($type_form == 'textarea'){
            $type = new Textarea($params[0]);
            return $type->get();
        } elseif($type_form == 'select') {
            $type = new Select($params[0]);
            return $type->get();
        } else {
            $type = new Input;
            return $type->input($type_form, $params[0]);
        }
    }

    /**
     * @param array $params
     * @return string
     */
    public function init(array $params): string{
        $start = new StartForm($params, $this->dic);
        return $start->get();
    }
}