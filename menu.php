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
				</ul>
			</dd>
		</dl>
		<?php
			} ?>
		<div class="new" data-new="category"><div></div></div>
		<dl>
			<dt class="menu edit text drag"><?php echo $row['title']; ?></dt>
			<dd>
				<ul>
					<div class="new" data-new="page"><div></div></div>
	<?php
		} if (isset($row['id'])) { ?>
					<li class="edit text drag drop sendto" data-url="?page=<?php echo $row['id']; ?>">
						<?php echo $row['short_title']; ?></li>
					<div class="new" data-new="page"><div></div></div>
	<?php
		} $pcat = $cat; } ?>
				</ul>
			</dd>
		</dl>
		<div class="new" data-new="category"><div></div></div>
	</div>
	<div id="edit">
		<ul>
			<li class="drag create">make new</li>
			<li class="drop delete">/dev/null</li>
		</ul>
	</div>
	<!-- This space for ads ;) -->
</div>
