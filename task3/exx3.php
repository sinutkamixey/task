<html>
	<head>
		<title>Задание 3</title>
	</head>
	<body>
		<?php	
		$Month1=require('month.php');
		if (isset($_GET['value'])) {
			$myDate=DateTime::createFromFormat('Y-m-d', $_GET['value']);
		}
		?>
		<form method="GET" action="exx3.php" >
			<input type="date" name="value" value="<?php 
			if (isset($myDate)){
				echo htmlspecialchars($myDate->format('Y-m-d'));
			}
			else{
				echo date('Y-m-d');
			}
			?>">
			<input type="submit" value="Рассчитать">
		</form>
		<table>
			<tr>	
				<th>Месяц</th>
				<th>Число</th>
			<tr>
			
		
		<?php
		
		if (isset($myDate)){
			$month = $myDate -> format('m');			
			$year = $myDate -> format('Y');	
			$day = $myDate -> Format('d');	
					
			for ($i=1; $i<=12; $i++) {
				$currentMonth =$month+1;
				$date=$myDate -> setDate((int)$year,(int)$currentMonth,1-1);
				
				$days = $date -> Format('d');
				$month = $date -> Format('m');
				$dayInWeek = $date -> Format('D');
				if ($mon == 12) {
					$year=$year+1;
				}
				if ($monthInText == 'Jun') {
					$year=$year+1;
				}
				if ($dayInWeek == 'Sat'){
					$days=$days+2;
					
					$currentDate=$date -> setDate((int)$year,(int)$month,$days);	
					
				}
				else if ($dayInWeek == 'Sun'){
					$days=$days+1;
					
					$currentDate=$date -> setDate((int)$year,(int)$month,$days);
					
				}
				else {
					
					$currentDate=$date -> setDate((int)$year,(int)$month,$days);	
					
				    
				}
				
				
		?>
			<tr>
				
				<td><?Echo $Month1[$month] . "  ";?></td>
				<td><?Echo $currentDate->format('d.m.Y') . "<br>";?></td>
		
				<?php $month=$month+1;
				$mon = $date -> format('m');
				
				
				
			}


			
		}	
		
		?>	
		</table>
	</body>
</html>
