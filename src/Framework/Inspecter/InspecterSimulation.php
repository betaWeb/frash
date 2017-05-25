<?php
namespace Frash\Framework\Inspecter;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Request\Server\Server;

/**
 * Class InspecterSimulation
 * @package Frash\Framework\Inspecter
 */
class InspecterSimulation{
    /**
     * @var Dic
     */
    private $dic;

    /**
     * InspecterSimulation constructor.
     * @param Dic $dic
     */
    public function __construct(Dic $dic){
        $this->dic = $dic;
    }

    /**
     * @param string $route
     */
    public function go(string $route){
        $session = $this->dic->load('session');
        $session->set('browser', true);

        $client = $this->dic->load('browser')->method(Server::requestMethod())->route($route)->go();
    }
}