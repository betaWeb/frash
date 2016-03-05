<?php
    namespace Composants\Framework\Exception;
    use Composants\Framework\Response\Response;
    use Composants\Framework\CreateLog\CreateErrorLog;
    use Composants\Yaml\Yaml;

    /**
     * Class TwigChargementTemplateFail
     * @package Composants\Framework\Exception
     */
    class TwigChargementTemplateFail{
        /**
         * TwigChargementTemplateFail constructor.
         * @param $templ
         */
        public function __construct($templ){
            $yaml = Yaml::parse(file_get_contents('Others/config/config.yml'));

            if($yaml['log']['error'] == 'yes'){
                new CreateErrorLog('Template TWIG Not Found');
            }

            return new Response('TplNotFound.html.twig', 'Exception', [ 'tpl' => $templ ]);
        }
    }