<?php
//delete single file
if(isset($_GET["q"]) && isset($_GET["r"]) && isset($_GET["s"]))
{
	$key=$_GET["q"].$_GET["r"];
	$b=str_ireplace(chr(47),chr(92),$_GET["s"]);
	$last2="";
					$seper2=explode(chr(92),$b);
					$count=count($seper2);
					$last2="";
					foreach($seper2 as $key2=>$valu2)
					{
						if($key2<$count-1)
						{
						$last2.=$valu2."/";
						}
					}
		if(is_dir("$key"))
		{
			rmdir("$key");
		}
		else
		{
			unlink("$key");
		}
		$last2=conv($last2,0);
					$seper2=str_split($last2);
					$count=count($seper2);
					$last2="";
					foreach($seper2 as $key2=>$valu2)
					{
						if($key2<$count-1)
						{
						$last2.=$valu2;
						}
					}
echo "<script>alert('Deleted');window.location.assign('$last2');</script>";
}
//remove directry
else if(isset($_GET["m"]) && isset($_GET["n"]))
{
	$key=$_GET["m"];
	$keyn=$_GET["n"];
	$last2="";
					$seper2=explode(chr(92),$key);
					$count=count($seper2);
					$last2="";
					foreach($seper2 as $key2=>$valu2)
					{
						if($key2<$count-1)
						{
						$last2.=$valu2."/";
						}
					}
		if(is_dir("$key"))
		{
			if(count(scandir("$key"))>2)
			{
					$dir = scandir("$key");
					foreach($dir as $val)
					{
						if($val!="." && $val!="..")
						{
							unlink("$key/$val");
						}
					}
			}
			rmdir("$key");			
		}
		$last2=$keyn.$last2;
		$last2=conv($last2,0);
		echo "<script>alert('Deleted');( window.parent || window ).location = '$last2..';</script>";
}
else{
	$url=getcwd()."\\file";
	$url=conv($url,0);
	echo "<script>alert('Something went wrong!!');( window.parent || window ).location = 'view.php?fileq=$url';</script>";
}
	function conv($m,$n)
	{
		$r="";
		if($n==0)
		{
			$r=str_replace(chr(92),chr(47),$m);
		}
		else
		{
			$r=str_replace(chr(47),chr(92),$m);
		}
		return $r;
	}
?>