<?php
namespace Frash\Framework\Inspecter;
use Frash\Framework\DIC\Dic;
use Frash\Framework\FileSystem\{ File, Json };
use Frash\Framework\Inspecter\InspecterRegistry;

/**
 * Class Inspecter
 * @package Frash\Framework\Inspecter
 */
class Inspecter{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * @var InspecterRegistry
     */
    private $registry;

    /**
     * Inspecter constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
        $this->registry = new InspecterRegistry;
    }

    /**
     * @return \Frash\Framework\Inspecter\InspecterSimulation
     */
    public function simulation(): InspecterSimulation{
        return new InspecterSimulation($this->dic);
    }

    /**
     * @return \Frash\Framework\Inspecter\InspecterRegistry
     */
    public function registry(): InspecterRegistry{
        return $this->registry;
    }

    public function display(){
        //$params = (array) array_merge([ 'true_route' => $route ], Json::decode(File::read('Storage/Cache/Analyzer/'.$file.'.json')));
        //return $this->dic->load('tpl')->internal('Analyzer', 'vendor/alixsperoza/frash/ressources/views/analyzer.tpl', $params);
    }
}