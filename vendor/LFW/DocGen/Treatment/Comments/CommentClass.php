<?php
	namespace LFW\DocGen\Treatment\Comments;

	class CommentClass{
		public static function work($comment){
			$comment = ltrim($comment, '/**');
			$comment = rtrim($comment, '*/');
			$comment = trim($comment);
			$comment = str_replace('* ', '', $comment);

			return $comment;
		}
	}