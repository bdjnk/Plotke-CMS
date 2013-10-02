<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (!function_exists('opendb'))
{
	function opendb()
	{
		$db;
		if (!isset($db))
		{
			$db = new mysqli("localhost", "plotke", "rAYLT4GMyGZFKBjY", "plotke");
			if ($db->connect_errno)
			{
				echo "Failed to connect to MySQL: ".$db->connect_error;
			}
		}
		return $db;
	}
}

if (!function_exists('get_posts'))
{
	function get_posts($page, $start = 0, $count = 10, $sort = "NULL", $author = "")
	{
		$db = opendb();
		$query = "
			SELECT
				UNIX_TIMESTAMP(post.time_published) as time_published,
				post.page_id,
				post.author_id,
				post.title,
				post.abstract,
				post.content,
				author.author_id,
				author.name
			FROM
				post,
				author
			WHERE
				post.page_id = $page
				AND
				author.name LIKE '%$author%'
				AND
				post.author_id = author.author_id
			ORDER BY
				$sort, time_published
			LIMIT
				$start, $count
		";
		if ($result = $db->query($query))
		{
			return $result;
		}
	}
}

?>
