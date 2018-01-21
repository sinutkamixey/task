<?php
$dbParams=require(
	'db.php'
);
$db= new PDO(
	"mysql:host=localhost;dbname=". 
	$dbParams['database'].
	";charset=utf8", 
	$dbParams['username'],
	$dbParams['password']
);

$marksSQL='
	SELECT `student`.`lastName`,`student`.`firstName`,`student`.`patronymicName`,`subject`.`name`, `mark`.`value` 	FROM `mark`	
	INNER JOIN `student` on `student`.`Id`=`mark`.`studentId`
	INNER JOIN `course` on `mark`.`courseId`=`course`.`Id`
	INNER JOIN `subject` on `subject`.`Id`=`course`.`subjectId`
	';
$values=[];	
if(isset($_GET['markSearch'])){
	$marksSQL .= '
	WHERE `mark`.`value` LIKE :value
	ORDER BY `value` DESC , `lastName`
	'; 
	$values['value']='%' . $_GET['markSearch'] . '%';
		
}	
$marksQuery=$db
	->prepare($marksSQL);
$marksQuery
	->execute($values);
$marks=$marksQuery
	->fetchAll(PDO::FETCH_ASSOC); 
?>	
<html>
<body>
	<form action="index.php" method="GET">
	<input type="radio" name="markSearch" value="<?php 3 or 4 or 5 ?>" >Любая
	<input type="radio" name="markSearch" value="5" <?php
					if (isset($_GET['markSearch'])) {
						echo ' checked';
					}
	?>>5		
	<input type="radio" name="markSearch" value="4" <?php
					if (isset($_GET['markSearch'])) {
						echo ' checked';
					}
	?>>4		
	<input type="radio" name="markSearch" value="3" <?php
					if (isset($_GET['markSearch'])) {
						echo ' checked';
					}
	?>>3
	<input type="submit"  value="Поиск">
		<a href="index.php">Все записи</a>
	</form>
	<table>
		<tr>
			<th>ФИО</th>
			<th>Дисциплина</th>
			<th>Оценка</th>
		<tr>
		<?php foreach ($marks as $mark){ ?>
		<tr>
			<td><?= htmlspecialchars($mark['lastName'].' '.$mark['firstName'].' '.$mark['patronymicName'])?></td>
			<td><?=htmlspecialchars($mark['name'])?></td>
			<td><?= '<center>'.htmlspecialchars($mark['value']).'</center>'?></td>
		<tr>
		<?php } ?>
	</table>
</body>	
</html>