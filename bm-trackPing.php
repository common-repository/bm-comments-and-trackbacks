<?php
/*
Plugin Name: BM-TrackPing
Version: 1
Plugin URI: http://www.binarymoon.co.uk/projects/bm-track-ping/ 
Description: Automagically separate comments, trackbacks, and pingbacks on your wordpress blog
Author: Ben Gillbanks
Author URI: http://www.binarymoon.co.uk/
*/

function bm_processComments( $comments ) {

	if( !$comments ) { return $comments; } 
	
	// set defaults 
 	$commentCounter		= 0;
 	$trackPingContent	= "";
 	
	foreach ( $comments as $comment ) {

		if ( $comment->comment_type == 'trackback' || $comment->comment_type == 'pingback' ) {
			
			$trackPingContent .= "<li><a href=\"" . $comment->comment_author_url . "\">" . $comment->comment_author . "</a></li>\n";
			array_splice( $comments, $commentCounter , 1 );
						
  		} else {
  		
  			$commentCounter ++;
  			
		}

	}
	
	// make sure there are some trackbacks
	if( $trackPingContent != "" ) {
	
		$newComment->comment_author = "Trackbacks";
		$newComment->comment_author_email = "Trackbacks";
		$newComment->comment_content = "<ul>\n" . $trackPingContent . "</ul>\n";
		$newComment->approved = 1;
		$newComment->comment_type = "bm-trackback";	
		$newComment->user_id = 0;	
		$newComment->comment_ID = "trackback";
		$newComment->comment_date = date('Y-m-d H:i:s');	
		$newComment->comment_date_gmt = gmdate('Y-m-d H:i:s');
		
		$comments[] = $newComment;

	}

	return $comments;

}

add_filter( 'comments_array', 'bm_processComments', 0 );

?>
