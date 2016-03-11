<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\Framework\ORM\MySQL\Request\Insert;
    use Composants\Framework\ORM\MySQL\QueryBuilder;

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
            $req->insert($ins->getRequest(), $ins->getExecute());
        }
	}