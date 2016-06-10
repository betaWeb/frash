<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Controller;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Yaml\Yaml;

    /**
     * Class TwigChargementTemplateFail
     * @package Composants\Framework\Exception
     */
    class TwigChargementTemplateFail extends Controller{
        /**
         * TwigChargementTemplateFail constructor.
         * @param $templ
         */
        public function __construct($templ){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                new CreateErrorLog('Template TWIG Not Found');
            }

            header("HTTP/1.0 404 Not Found");
            return $this->view('TplNotFound.html.twig', 'Exception', [ 'tpl' => $templ ]);
        }
    }