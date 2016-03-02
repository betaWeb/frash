<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\Insert;
    use Composants\ORM\QueryBuilder;

    /**
     * Class ContactRequests
     * @package Bundles\GameBundle\Requests
     */
	class ContactRequests{
        /**
         * @param $text
         */
		public function sqlInsertContact($text){
            $req = new QueryBuilder();
            $ins = new Insert('contact');
            $ins->setInsert([ 'texte', 'pseudo' ]);
            $ins->setExecute([ $text, $_SESSION['pseudo'] ]);
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }
	}