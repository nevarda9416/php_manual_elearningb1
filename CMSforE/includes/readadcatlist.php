<?php
if(isset($_GET['readadid']))
{
	$strSQL = "SELECT * FROM categories WHERE ParentID='".$_GET['readadid']."'";
	$result = mysql_query($strSQL,$link);
	$row = mysql_fetch_array($result);
}
else
{
	header('Location: index.php');
}
?>
<div class="heading">
<div class="title">
&laquo; Luyện kĩ năng đọc
</div>
<div class="icon_reading">
</div>
</div>
<div class="content">
<div class="searchcat">
<form action="#" method="get" name="searchcat">
<table border="0" cellpadding="3" cellspacing="3">

<tr>
<td align="" style="border: 1px solid #cdc9c4; color: #FFF">Điền tên bài học:</td>
<td>
<input name="keyword" type="text" style="background: #e2e2e2;width: 260px; height: 20px;" />
</td>
<td align="">
<input name="SearchCat" type="submit" value="Tìm kiếm" style="font-family:'Times New Roman', Times, serif" />
</td>
</tr>
</table>
</form>
</div>
<div class="uleft">
<ul>
	<?php
	$p=11;
	if(isset($_GET['n']))
	{
		$n=$_GET['n'];//Lấy biến n trên trình duyệt
	}
	else
	{
		$n=1;
	}
	$s=($n-1)*$p;
	$sql1="SELECT * FROM categories WHERE ParentID = '".$_GET['readadid']."'";
	$result1=mysql_query($sql1,$link);
	$n_record=mysql_num_rows($result1);
	
	function view_page()
	{
		global $n_record;
		global $p;
		for($i=1;$i<=ceil($n_record/$p);$i++)
		{
			echo '<a href="view_readadcatlist.php?n='.$i.'&readadid='.$_GET['readadid'].'" style="color: #006666;background: #ccc; border: 1px solid #006666; padding: 2px;">'.$i.'</a><font color="#006666">&nbsp;&rsaquo;&nbsp;</font>';	
		}
			echo '<a href="view_readadcatlist.php?n=All&readadid='.$_GET['readadid'].'" style="color: #006666;background: #CCC; border: 1px solid #006666;padding: 2px;"> All</a>';
			echo '<br/><br/>';
	}
	if($n!='All')
	{
		if(isset($_GET['readadid']))
		{
			$sql="SELECT * FROM categories WHERE ParentID ='".$_GET['readadid']."' limit $s, $p";
		}
	}
	else
	{
		if(isset($_GET['readadid']))
		{
			$sql="SELECT * FROM categories WHERE ParentID ='".$_GET['readadid']."'";
		}
	}
	view_page();
	$result=mysql_query($sql, $link);
	$sort=0;
	while($row=mysql_fetch_array($result))
	{
		$sort++;
		echo '<li>
		<div class="left"><a href="view_readaddetaillist.php?readaddetailid='.$row['id'].'">'.$sort.' - '.$row['name'].' - '.$row['ParentID'].'</a><div>
		
		</li>';
	}
	?>
</ul>
</div>
</div>