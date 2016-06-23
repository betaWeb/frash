<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Controller;
    use Composants\Framework\CreateLog\CreateErrorLog;

    /**
     * Class TwigChargementTemplateFail
     * @package Composants\Framework\Exception
     */
    class TwigChargementTemplateFail extends Controller{
        /**
         * TwigChargementTemplateFail constructor.
         * @param string $templ
         */
        public function __construct($templ){
            new CreateErrorLog('Template TWIG Not Found');

            return $this->view('TplNotFound.html.twig', 'Exception', [ 'tpl' => $templ ]);
        }
    }