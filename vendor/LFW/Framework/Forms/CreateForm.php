<?php
    namespace LFW\Framework\Forms;
    use LFW\Framework\DIC\Dic;

    /**
     * Class CreateForm
     * @package LFW\Framework\Forms
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
         * @param array $spec
         * @return string
         */
        public function create(string $type_form, array $spec): string{
            $routing = $this->path.$type_form;

            if($type_form == 'StartForm'){
                $type = new $routing($spec, $this->dic);
            }
            else{
                $type = new $routing($spec);
            }

            return $type->getInput();
        }
    }