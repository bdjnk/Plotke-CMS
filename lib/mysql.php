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
			$db = new mysqli("localhost", "plotke", "rAYLT4GMyGZFKBjY");#, "plotke");
			if ($db->connect_errno)
			{
				echo "Failed to connect to MySQL: ".$db->connect_error;
			}
			#echo "check for 'plotke' db";
			if (!$db->select_db("plotke"))
			{
				echo "no 'plotke' db found";

				if ($db->query("CREATE DATABASE	plotke"))
				{
					$db->select_db("plotke");

					$query = "
						CREATE TABLE author (
							id INT AUTO_INCREMENT PRIMARY KEY,
							name VARCHAR(64)
						) ENGINE = InnoDB;
						CREATE TABLE category (
							id INT AUTO_INCREMENT PRIMARY KEY,
							sort INT,
							title VARCHAR(64)
						) ENGINE = InnoDB;
						CREATE TABLE page (
							id INT AUTO_INCREMENT PRIMARY KEY,
							sort INT,
							short_title VARCHAR(64),
							long_title VARCHAR(128),
							description VARCHAR(512),
							category_id INT,
							CONSTRAINT fk_category
								FOREIGN KEY (category_id)
								REFERENCES category (id)
								ON UPDATE RESTRICT
						) ENGINE = InnoDB;
						CREATE TABLE post (
							id INT AUTO_INCREMENT PRIMARY KEY,
							title VARCHAR(128),
							abstract VARCHAR(512),
							content TEXT,
							time_published DATETIME,
							page_id INT,
							author_id INT,
							CONSTRAINT fk_author
								FOREIGN KEY (author_id)
								REFERENCES author (id)
								ON UPDATE RESTRICT,
							CONSTRAINT fk_page
								FOREIGN KEY (page_id)
								REFERENCES page (id)
								ON UPDATE RESTRICT
						) ENGINE = InnoDB;
					";
					$db->multi_query($query);
					while ($db->more_results()) { $db->next_result(); }

					if ($db->errno)
					{ 
						echo "Failed to create tables: ".$db->error; 
					}
				}
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
				category.sort,
				category.title,
				page.sort,
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
