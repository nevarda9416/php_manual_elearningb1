<?php
if(isset($_GET['readaddetailid']))
{
	$strSQL = "SELECT * FROM lessons_readad WHERE catid='".$_GET['readaddetailid']."'";
	$result = mysql_query($strSQL, $link);
	$row = mysql_fetch_array($result);
	$totalRow=mysql_num_rows($result);
}
else
{
	header('Location: view_readadcatlist.php');
}
?>
<div class="heading">
<div class="title">
&laquo; Luyện kĩ năng đọc (Bài học dưới dạng các câu hỏi thực hành)
</div>
<div class="icon_reading">
</div>
</div>
<div class="content">
<div class="uleft">
<ul>
	<form action="#" method="post">
	<?php
	$strSQL = "SELECT * FROM lessons_readad WHERE catid = '".$_GET['readaddetailid']."'";
	$result = mysql_query($strSQL, $link);
	$sort=0;
	while($row=mysql_fetch_array($result))
	{
		$sort++;
		echo '<li style="float: left; height: 270px;">'.'<b>'.$sort.'. '.$row['title'].':</b><br/>'.
		'<div style="width: 319px; border: 1px solid #666; text-align: center;">'.$row['content_ad'].'</div><br/>'.
		$row['content_answer'].'<br/><br/>'.
		'Answer is: '.'<input type="text" name="txtanswer'.$sort.'" id="txtanswer" style="width: 50px; border: 1px solid #790000;"/>'.
		'<input type="hidden" name="id'.$sort.'" value="'.$row['id'].'">'.
		
		'</li>';
	
	}
	?>
    <li>
    <input type="submit" name="submit" value="Kiểm tra đáp án" style="font-family: 'Times New Roman', Times, serif"/>
    <input type="reset" name="reset" value="Làm lại" style="font-family: 'Times New Roman', Times, serif"/>
    <input type="submit" name="check" value="Xem đáp án" style="font-family: 'Times New Roman', Times, serif"/>
    </li>
	</form>
</ul>
</div>
</div>
<?php

if(isset($_POST['check']))
{
	if(!isset($_SESSION['logged']))
	{
	header('Location: login.php');
	}
	else
	{
	$s=0;
	$t=1;
	echo '<b><i>Key</b></i><br/>';
	for($u=0;$u<$sort;$u++)
	{
		
		$id=$_POST['id'.$t];
		$strSQL3 = "SELECT * FROM lessons_readad WHERE id='".$id."'";
		$result3=mysql_query($strSQL3,$link);
		
		while($row3=mysql_fetch_array($result3))
		{
			echo '<b>'.$t.'. </b>'.$row3['title'].': ';
			echo '<b>'.$row3['correct_answer'].'</b><br/>';	
		}
		$t++;
	}
	}
}
if(isset($_POST['submit']))
{
	$count=0;
	$k=1;
	echo '<b><i>Đáp án vừa trả lời</i></b><br/>';
	for($i=0;$i<$sort;$i++)
	{
	$id=$_POST['id'.$k];
	$answer=$_POST['txtanswer'.$k];
	if($answer=="")
	{
		$answer='E';	
	}
	if($answer=="a")
	{
		$answer='A';	
	}
	if($answer=="b")
	{
		$answer='B';	
	}
	if($answer=="c")
	{
		$answer='C';	
	}
	
	$strSQL2 = "SELECT * FROM lessons_readad WHERE id='".$id."'";
	//echo $strSQL2;
	$result2=mysql_query($strSQL2,$link);
	
	while($row2=mysql_fetch_array($result2))
	{
	if($row2['correct_answer']==$answer)
	{
		echo '<b>'.$k.') '.$row2['title'].': '.$answer.' - </b><font color="#002596">True</font><br/>';
	}
	else
	{
		echo '<b>'.$k.') '.$row2['title'].': '.$answer.' - </b><font color="#fd0309">False</font><br/>';
	}
	}
	$strSQL4 = "SELECT * FROM lessons_readad WHERE id='".$id."' AND correct_answer='".$answer."'";
	$result4=mysql_query($strSQL4,$link);
	$totalRow4=mysql_num_rows($result4);
	if($totalRow4>0)
	$count++;
	$k++;
	}
	$percent=($count/$totalRow)*100;
	echo '<p><b>Số câu đúng là: '.$count.'/'.$totalRow.'. Đạt: '.$percent.'%</b></p>';
	
	
}
?>