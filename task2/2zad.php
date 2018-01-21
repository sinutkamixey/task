<?php
$db = new PDO(
  "mysql:host=localhost;dbname=faculty;charset=utf8", 
  "faculty",
  "faculty"
);

?>
<html>
	<body>
		<form method="GET" action="2zad.php">
			<?php
				$subjects = $db->query('
					SELECT * FROM `subject`
				')->fetchAll();
			?>
			<select name="subject">
				<?php foreach ($subjects as $subject) { ?>
				<option
					value="<?= htmlspecialchars($subject['id']) ?>"
					<?php
						if (
							isset($_GET['subject']) &&
							$_GET['subject'] == $subject['id']
						) {
							echo ' selected';
						}
					?>
				>
					<?= htmlspecialchars($subject['name']) ?>
				</option>
				<?php } ?>
			</select>
			<input type="submit" value="Найти">
		</form>
		<?php 
		if (isset($_GET['subject'])) { 
			$query = $db->prepare('
				SELECT DISTINCT  `group`.`number`   FROM `group`
                INNER Join `course` ON `group`.id =`course`.groupId
                INNER JOIN `mark` ON `mark`.courseId= `course`.id
                INNER Join `subject` ON `subject`.`id`= `course`.`subjectId`
				Where course.subjectId= :subject
			');
			$query->execute(['subject' => $_GET['subject']]);
			$groups = $query->fetchAll();
			if (count($groups) > 0) {
			?>
			<ul>
				<?php foreach ($groups as $group) { ?>
					<li><?= htmlspecialchars($group['number']) ?></li>
				<?php } ?>
			</ul>
			<?php
			} else {
				?><div>групп не найдено</div><?php
			}
		}
		?>
	</body>
</html>