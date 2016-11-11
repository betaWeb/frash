<?php
	namespace LFW\Framework\Templating\Extensions;

	class RemoveComment{
		public static function remove($tpl){
			preg_match_all('/\[comment\](.*?)\[\/comment\]/s', $tpl, $matches);

			$commentary = [];
			foreach($matches[1] as $comment){
				$commentary[] = $comment;
				$tpl = str_replace('[comment]'.$comment.'[/comment]', '', $tpl);
			}

			return [ 'comment' => $commentary, 'tpl' => $tpl ];
		}
	}