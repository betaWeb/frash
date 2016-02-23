<?php
	namespace Bundles\GameBundle\Requests;
    use Composants\ORM\Request\Insert;
    use Composants\ORM\Request\QueryBuilder;

	class ContactRequests{
		public function sqlInsertContact($text){
            $req = new QueryBuilder();
            $ins = new Insert('contact');
            $ins->setInsert([ 'texte', 'pseudo' ]);
            $ins->setExecute([ $text, $_SESSION['pseudo'] ]);
            $ins->requestInsert();
            $req->execRequest($ins->getRequest(), $ins->getExecute());
        }
	}