<?php
	namespace LFW\DocGen\Treatment\Comments;

    /**
     * Class CommentClass
     * @package LFW\DocGen\Treatment\Comments
     */
	class CommentClass{
		/**
		 * @param string $comment
		 * @return string
		 */
		public static function work(string $comment): string{
			$comment = ltrim($comment, '/**');
			$comment = rtrim($comment, '*/');
			$comment = trim($comment);
			$comment = str_replace('* ', '', $comment);

			return $comment;
		}
	}