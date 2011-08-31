<form action="../market/add" method="post">
<input type="text" value="Your question..." onclick="this.value=''" name="market">
<br/>
<input type="text" value="Expiration date..." onclick="this.value=''" name="end_date">
<br/>
<input type="submit" value="add">
</form>

<br/><br/>
<?php $number = 0?>

<?php foreach ($market_db as $todoitem):?>
	<a class="big" target="_top" href="../market/view/<?php echo strtolower(str_replace(" ","-",$todoitem['Market']['market']))?>">
	<span class="item">
	<?php echo ++$number?>. 
        <?php echo $todoitem['Market']['market']?>
	</span>
	</a><br/>
<?php endforeach?>