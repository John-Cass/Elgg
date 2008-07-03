<?php
	/**
	 * Elgg groups plugin
	 * 
	 * @package ElggGroups
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Marcus Povey
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.com/
	 */

	require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

	$limit = get_input("limit", 10);
	$offset = get_input("offset", 0);
	$tag = get_input("tag");
	
	
	// Get objects
	$context = get_context();
	
	set_context('search');
	if ($tag != "")
		$objects = list_entities_from_metadata('tags',$tag,'group',"","", $limit, false);
	else
		$objects = list_entities('group',"", 0, $limit, false);
		
	set_context($context);
	
	$body = elgg_view_layout('one_column',$objects);
	
	// Finally draw the page
	page_draw(sprintf(elgg_echo("groups:all"),page_owner_entity()->name), $body);



?>