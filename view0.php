<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
session_start();
	if(isset($_SESSION["file_opened"]) && !isset($_GET["fileq"]))
		{
			$_GET["fileq"]=$_SESSION["file_opened"];
		}
?>
<html>
<head>
<style type="text/css">
form{
	font-size:15px;
	width: 1000px;
	}
a{
		text-decoration:none;
		color:blue;
	}
.fn{
	color:lime;
}
.fn a{
	//text-transform:uppercase;
}
.nf{
	color:Magenta;
}
.sz{
	color:lime;
}
.tm{
	color:violet;
}
.op a{
	color:orange;
}
th{
	color:green;
	font-weight:bold;
	font-size:18px;
	padding:2px 2px 2px 2px;
	text-transform: capitalize;
}
.hl{
	width:800px;
	border:solid 1px black;
}
.hh th,.dd td{
	border:solid 1px silver;
}
.dd .bk{
	border:none;
}
</style>
<script src="api/jquery.js"></script>
</head>
<body>
<?php

			function Size($path)
			{
				$bytes = sprintf('%u', filesize($path));
                if(is_dir($path))
    			{
					return "[Folder]";
				}
				if ($bytes > 0)
				{
					$unit = intval(log($bytes, 1024));
					$units = array('B', 'KB', 'MB', 'GB');

					if (array_key_exists($unit, $units) === true)
					{
						return sprintf('%d%s', $bytes / pow(1024, $unit), $units[$unit]);
					}
				}
			}

			function file_open($cur_dir)
			{	
				$cur_dir=conv($cur_dir,1);
				$_SESSION["file_opened"]=$cur_dir;
				echo "<form action='view0.php' method='get'>";
				$cur_host='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
				$host='http://'.$_SERVER['HTTP_HOST'];
				//echo ($cur_host)."<br />".$cur_dir."<br />";
				$path=pathinfo($cur_dir);
				if(isset($dirname))
				{
				$dirname=$path['dirname'];
				}
				$basename=$path['basename'];
				$filename=$path['filename'];
				if(isset($path['extension']))
				{$extension=$path['extension'];}

					$cur_host2=explode(chr(47),$cur_host);
					$cur_dir2=explode(chr(92),$cur_dir);
					$comb=array_intersect($cur_host2,$cur_dir2);
					$seper=array_diff($cur_dir2,$cur_host2);
					$file_key=array_search("file",$seper);
					$last="";
					foreach($seper as $key=>$valu)
					{
						if($key>=$file_key && preg_match("/[.]/i",$valu)!=1)
						$last.="/".$valu;
					}
					$diff=implode(chr(47),$seper);
					$match="/".implode(chr(47),$comb)."$last/";
					echo "<h4>$match<h4>";
					if(preg_match("/\/file/i",$match)==0)
					{
						unset($_SESSION["file_opened"]);
						echo "<script>( window.parent || window ).location = 'http://guruinfo.epizy.com/edu.html';</script>";
						exit();//do not allow to visit root directory
					}
			    $cur_dir=str_replace("\\","/",$cur_dir);
				if(is_dir($cur_dir))
				{
					echo "<table class='hl'>";
					echo "<tr class='hh'><th>file name</th><th>Size</th><th>Date of upload</th></tr>";
					$dir = scandir("$cur_dir/");
					$back="$cur_host?fileq=$cur_dir\\..";
					$back=conv($back,0);
					echo "<tr class='dd'><td class='bk'>"."<a href='$back'><<</a></td></tr>";
							foreach($dir as $val)
							{
								if($val!="." && $val!="..")
								{
									$url="$cur_host?fileq=$cur_dir\\$val";
									$url=conv($url,0);
									$fileurl="$cur_dir\\$val";
									$fileurl=conv($fileurl,0);
									$tim=date("d-m-Y H:i:s", filemtime("$cur_dir/$val"));
									echo "<tr class='dd'>";
										echo "<td class='fn'><a href='$url'>$val</a></td><td class='sz'>".Size("$cur_dir/$val")."</td><td class='tm'>$tim</td>";
									echo "</tr>";
								}
							}
						echo "</table>";	
				}
				else
				{
					echo "<table class='ff'>";
					$last2="";
					$seper2=explode(chr(47),$match);
					//print_r($seper2);
					$count=count($seper2);
					$file_key2=array_search("file",$seper2);
					$last2="";
					foreach($seper2 as $key2=>$valu2)
					{
						if($key2>=$file_key2 && $key2<$count-1)
						{
						$last2.=$valu2."/";
						}
					}
                    $temp_file=explode("\\",$filename);
					$download_url=$host.$match.array_pop($temp_file).".".$extension;
					$del_url="del.php?q=$last2&r=$filename.$extension&s=$cur_host?fileq=$cur_dir";
					$download_url=conv($download_url,0);
					$del_url=conv($del_url,0);
					$back="$cur_host?fileq=$cur_dir\\..";
					$back=conv($back,0);
                    $download_url=str_replace("\\","/",$download_url);
					echo "<tr class='df'><td class='bk'>"."<a href='$back'><<</a></td></tr>";	
						echo "<tr class='df'><th class='fn'>File name:</th><td class='nf'>$download_url</td></tr>";
						echo "<tr class='df'><td class='down'>"."<a href='$download_url' ><u>Download</u> &gt&gt</a><br />If probleom in dowwnloading:<a href='' onclick=\"window.open('$download_url')\"><u> click here to Download</u> &gt&gt</a></td></tr>";
						//echo "<tr class='df'><td class='op'>"."<a href='$del_url'>Delete</a></td></tr>";
				}
				echo "</table><form>";
			}
	if(isset($_GET["fileq"]))
	{
		if(preg_match("/\.\./i",$_GET["fileq"]))
		{
			$aaa=explode(chr(47),$_GET["fileq"]);
			array_pop($aaa);
			array_pop($aaa);
			$_GET["fileq"]=implode(chr(92),$aaa);
		}
		file_open($_GET["fileq"]);
	}
	else
	{
		//actual working directory
		$j=getcwd()."\\file";
		file_open($j);
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
</body>
</html>