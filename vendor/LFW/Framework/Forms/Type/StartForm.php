<?php
    namespace LFW\Framework\Forms\Type;
    use LFW\Framework\DIC\Dic;
    use LFW\Framework\Forms\FormTypeInterface;
    use LFW\Framework\Globals\Session;
    use LFW\Framework\Forms\Type\Csrf;

    /**
     * Class StartForm
     * @package LFW\Framework\Forms\Type
     */
    class StartForm{
        /**
         * @var string
         */
        private $input;

        /**
         * StartForm constructor.
         * @param array $spec
         * @param Dic $dic
         */
        public function __construct($spec, Dic $dic){
            $this->input = '<form';

            if(!empty($spec['method'])){
                $this->input .= ' method="'.$spec['method'].'"';
            }

            if(!empty($spec['action'])){
                $this->input .= ' action="'.$dic->load('getUrl')->url($spec['action']).'"';
            }

            if(!empty($spec['id'])){
                $this->input .= ' id="'.$spec['id'].'"';
            }

            if(!empty($spec['class'])){
                $this->input .= ' class="'.$spec['class'].'"';
            }

            if(!empty($spec['title'])){
                $this->input .= ' title="'.$spec['title'].'"';
            }

            if(!empty($spec['enctype'])){
                $this->input .= ' enctype="'.$spec['enctype'].'"';
            }

            if(!empty($spec['dir'])){
                $this->input .= ' dir="'.$spec['dir'].'"';
            }

            $this->input .= '>';

            if(!empty($spec['csrf']) && $spec['csrf'] == 'yes'){
                $name = (!empty($spec['csrf_name'])) ? $spec['csrf_name'] : 'token';

                $sess = new Session();
                $csrf = new Csrf([ 'session' => $sess->setSession($name, uniqid(rand(), true)), 'name' => $name ]);

                $this->input .= $csrf->getInput();
            }
        }

        /**
         * @return string
         */
        public function getInput(){
            return $this->input;
        }
    }