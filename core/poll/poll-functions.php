<?php

add_action('init', 'poll_add_rewrite_rules');
add_filter('query_vars', 'poll_add_query_vars');
add_filter('template_include', 'poll_add_template');

function poll_add_template($template)
{
	$poll_id = get_query_var('poll_id');
//	$secret_key = get_query_var('secret_key');

	if ($poll_id) {
		return get_template_directory() . '/core/poll/page-poll.php';
	}
	return $template;
}

function poll_add_rewrite_rules()
{
    flush_rewrite_rules(true);
	add_rewrite_rule('p/([a-zA-Z0-9]+?)/?$', 'index.php?poll_id=$matches[1]', 'top');
	add_rewrite_rule('o/([a-zA-Z0-9]+?)/?$', 'index.php?poll_id=$matches[1]&poll360=1', 'top');
//	add_rewrite_rule('poll\/([0-9]+?)\/?sk=([0-9]+?)\/?$', 'index.php?poll_id=$matches[1]&secret_key=$matches[2]', 'top');
}

function poll_add_query_vars($vars)
{
	$vars[] = 'poll_id';
	$vars[] = 'poll360';
//	$vars[] = 'secret_key';
	return $vars;
}