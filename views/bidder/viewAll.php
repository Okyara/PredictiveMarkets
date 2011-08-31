<form action="../bidder/add" method="post">
<input type="text" value="My loggin..." onclick="this.value=''" name="login">
<input type="text" value="My password..." onclick="this.value=''" name="password">
<input type="submit" value="add">
</form>

<br/><br/>
<?php $number = 0?>
<?php foreach ($market_db as $todoitem):?>
	<a class="big" target="_top" href="../bidder/view/<?php echo $todoitem['Bidder']['bidder_id']?>/<?php echo strtolower(str_replace(" ","-",$todoitem['Bidder']['login']))?>">
	<span class="item">
	<?php echo ++$number?>
	<?php echo $todoitem['Bidder']['login']?>
	</span>
	</a><br/>
<?php endforeach?>
