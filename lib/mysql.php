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

if (!function_exists('get_page'))
{
	function get_info($page)
	{
		$db = opendb();
		$query = "
			SELECT
				long_title,
				description
			FROM page
			WHERE id = '$page'
		";
		if ($result = $db->query($query))
		{
			return $result;
		}
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
				post.id,
				post.title,
				post.abstract,
				author.name
			FROM
				post,
				author
			WHERE
				post.page_id = $page
				AND
				author.name LIKE '%$author%'
				AND
				post.author_id = author.id
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

if (!function_exists('get_pages'))
{
	function get_pages()
	{
		$db = opendb();
		$query = "
			SELECT
				category.id as cat,
				category.title,
				page.id,
				page.short_title
			FROM
				category
				LEFT JOIN
					page
						ON
							category.id = page.category_id
			ORDER BY
				category.order,
				category.title,
				page.order,
				page.short_title
		";
		if ($result = $db->query($query))
		{
			return $result;
		}
	}
}

if (!function_exists('get_post'))
{
	function get_post($post)
	{
		$db = opendb();
		$query = "
			SELECT
				UNIX_TIMESTAMP(post.time_published) as time_published,
				post.id,
				post.title,
				post.abstract,
				post.content,
				author.name
			FROM
				post,
				author
			WHERE
				post.id = $post
				AND
				post.author_id = author.id
		";
		if ($result = $db->query($query))
		{
			return $result;
		}
	}
}

function debugVar($var, $desc)
{
	echo "\n<!-- $desc\n".print_r($var, true)."\n-->\n";
}
?>
