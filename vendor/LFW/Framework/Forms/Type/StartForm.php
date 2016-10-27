<?php
    namespace LFW\Framework\Forms\Type;
    use LFW\Framework\Controller\GetUrl;
    use LFW\Framework\Forms\FormTypeInterface;
    use LFW\Framework\Globals\Session;

    /**
     * Class StartForm
     * @package LFW\Framework\Forms\Type
     */
    class StartForm implements FormTypeInterface {
        /**
         * @var string
         */
        private $input;

        /**
         * StartForm constructor.
         * @param array $spec
         */
        public function __construct($spec){
            $url = new GetUrl;
            $this->input = '<form';

            if(!empty($spec['method'])){
                $this->input .= ' method="'.$spec['method'].'"';
            }

            if(!empty($spec['action'])){
                $this->input .= ' action="'.$url->url($spec['action']).'"';
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
                $sess = new Session();
                $csrf = new Csrf($sess->getSession('token'));

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