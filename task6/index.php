<?php
$db = new PDO(
  "mysql:host=localhost;dbname=faculty;charset=utf8", 
  "faculty",
  "faculty"
);

?>
<html>
	<body>
		<form method="GET" action="index.php">
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
			<label>
				Отображать только учащихся студентов
				<input type="checkbox" name="study"<?php
					if (isset($_GET['study'])) {
						echo " checked";
					}
				?>>
			</label>
			<input type="submit" value="Найти">
		</form>
		<?php 
		if (isset($_GET['subject'])) { 
			$sql = '
				SELECT student.lastName FROM student
                INNER Join `group` on `group`.id=student.groupId
                INNER JOIN `course` on course.groupId=`group`.`id`
				INNER JOIN subject ON subject.id=course.subjectId
				WHERE course.subjectId = :subject
			';
			if (isset($_GET['study'])) {
				$sql .= ' and student.status >= 1';
			}
			$sql .= ' ORDER BY student.lastName ASC';
			$query = $db->prepare($sql);
			$query->execute(['subject' => $_GET['subject']]);
			$students = $query->fetchAll();
			if (count($students) > 0) {
			?>
			<ul>
				<?php foreach ($students as $student) { ?>
					<li>
						<?= htmlspecialchars($student['lastName']) ?>
						
					</li>
				<?php } ?>
			</ul>
			<?php
			} else {
				?><div>Студентов не найдено</div><?php
			}
		}
		?>
	</body>
</html>