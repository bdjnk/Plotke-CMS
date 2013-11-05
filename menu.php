<div class="spacer"></div>

<div id="sidebar">
	<div id="menu">
<?php
	$result = get_pages();
	$pcat = FIRST;
	while ($row = $result->fetch_assoc()) {
		$cat = $row['cat'];
		if ($pcat != $cat) {
			if ($pcat != FIRST) { ?>
					<li class="new page hide">new_page</li>
				</ul>
			</dd>
		</dl>
		<?php
			} ?>
		<dl>
			<dt class="menu edit text drag"><?php echo $row['title']; ?></dt>
			<dd>
				<ul>
	<?php
		} if (isset($row['id'])) { ?>
					<li data-url="?page=<?php echo $row['id']; ?>" class="edit text drag">
						<?php echo $row['short_title']; ?></li>
	<?php
		} $pcat = $cat; } ?>
					<li class="new page hide">new_page</li>
				</ul>
			</dd>
		</dl>
		<dl>
			<dt class="new category hide">new_category</dt>
		</dl>
	</div>
	<div id="edit">
		<ul>
			<li data-func="mk" class="drag">touch</li>
			<li data-func="rm" class="drop">/dev/null</li>
		</ul>
	</div>
	<!-- This space for ads ;) -->
</div>
