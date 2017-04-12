<?php
namespace Frash\Framework\Request\Session;
use Frash\Framework\DIC\Dic;
use Frash\Framework\Request\Server\Server;

class StockRoute
{
    public static function create(array $config, Dic $dic)
    {
        if(!empty($config['stock_route']) && $config['stock_route'] == 'yes'){
            $session = $dic->load('session');

            if($session->has('frash_current_url')){
                $session->set('frash_before_url', $session->get('frash_current_url'));
            } else {
                $session->set('frash_before_url', Server::httpReferer());
            }

            $session->set('frash_current_url', Server::uri());
        }
    }
}