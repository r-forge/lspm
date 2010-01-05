
<!-- This is the project specific website template -->
<!-- It can be changed as liked or replaced by other content -->

<?php

$domain=ereg_replace('[^\.]*\.(.*)$','\1',$_SERVER['HTTP_HOST']);
$group_name=ereg_replace('([^\.]*)\..*$','\1',$_SERVER['HTTP_HOST']);
$themeroot='http://r-forge.r-project.org/themes/rforge/';

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en   ">

  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo $group_name; ?></title>
	<link href="<?php echo $themeroot; ?>styles/estilo1.css" rel="stylesheet" type="text/css" />
  </head>

<body>

<!-- R-Forge Logo -->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr><td>
<a href="/"><img src="<?php echo $themeroot; ?>/images/logo.png" border="0" alt="R-Forge Logo" /> </a> </td> </tr>
</table>


<!-- get project title  -->
<!-- own website starts here, the following may be changed as you like -->

<?php if ($handle=fopen('http://'.$domain.'/export/projtitl.php?group_name='.$group_name,'r')){
$contents = '';
while (!feof($handle)) {
	$contents .= fread($handle, 8192);
}
fclose($handle);
echo $contents; } ?>

<!-- end of project description -->
<div>
These examples are based on revision 31 from r-forge and <u>will not work under earlier revisions</u> (and may not work with later revisions). LSPM is still in <b>very</b> alpha status.&nbsp; Expect things to change, perhaps significantly.<br /> 
<br /> 
These examples were run using code from DEoptim_1.3-3 that has been bundled inside LSPM.&nbsp; We are working with the DEoptim authors to address issues with more recent versions of DEoptim.&nbsp; LSPM will use the most recent version of DEoptim as soon as the issues are resolved.<br /> 
<br /> 
The first two examples are taken from <a href="http://www.amazon.com/gp/product/0470455950?ie=UTF8&amp;tag=fotr09-20&amp;linkCode=as2&amp;camp=1789&amp;creative=9325&amp;creativeASIN=0470455950">Vince, Ralph (2009). The Leverage Space Trading Model. New York: John Wiley &amp; Sons, Inc.</a><img alt="" border="0" class=" kkhzmhumvwvpsurumhgy kkhzmhumvwvpsurumhgy kkhzmhumvwvpsurumhgy kkhzmhumvwvpsurumhgy" height="1" src="http://www.assoc-amazon.com/e/ir?t=fotr09-20&amp;l=as2&amp;o=1&amp;a=0470455950" style="border: medium none ! important; margin: 0px ! important;" width="1" />  The results will not match the book because of differences between optimization via DEoptim and Ralph's genetic algorithm implementation.&nbsp; Ralph believes his genetic algorithm is getting hung up on a local maximum, whereas DEoptim is closer to the global solution.<br /> 
<ol></ol><br /> 
<div style="font-family: &quot;Courier New&quot;,Courier,monospace;"><span style="font-size: x-small;"># Load the LSPM package</span><br /> 
</div><div style="font-family: &quot;Courier New&quot;,Courier,monospace;"><span style="font-size: x-small;">library(LSPM)</span><br /> 
<br /> 
<span style="font-size: x-small;"># Multiple strategy example (data found on pp. 84-87)<br /> 
trades &lt;- cbind(<br /> 
&nbsp;c(-150,-45.33,-45.33,rep(13,5),rep(79.67,3),136),<br /> 
&nbsp;c(253,-1000,rep(-64.43,3),253,253,448,rep(-64.43,3),253),<br /> 
&nbsp;c(533,220.14,220.14,-500,533,220.14,799,220.14,-325,220.14,533,220.14) )<br /> 
probs </span><span style="font-size: x-small;">&lt;-</span><span style="font-size: x-small;"> c(rep(0.076923077,2),0.153846154,rep(0.076923077,9))<br /> 
&nbsp;</span><br /> 
</div><div style="font-family: &quot;Courier New&quot;,Courier,monospace;"><span style="font-size: x-small;"># Create a Leverage Space Portfolio object</span><br /> 
</div><div style="font-family: &quot;Courier New&quot;,Courier,monospace;"><span style="font-size: x-small;">port </span><span style="font-size: x-small;">&lt;</span><span style="font-size: x-small;">- lsp(trades,probs)<br /> 
<br /> 
# DEoptim parameters (see ?DEoptim)<br /> 
# NP=30&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (10 * number of strategies)<br /> 
# itermax=100&nbsp; (maximum number of iterations)<br /> 
DEctrl </span><span style="font-size: x-small;">&lt;</span><span style="font-size: x-small;">- list(NP=30,itermax=100)<br /> 
<br /> 
# Unconstrainted Optimal f (results on p. 87)<br /> 
res </span><span style="font-size: x-small;">&lt;</span><span style="font-size: x-small;">- optimalf(port,control=DEctrl)<br /> 
<br /> 
</span><span style="font-size: x-small;"># Drawdown-constrained Optimal f (results on p. 137)<br /> 
# Since horizon=12, this optimization will take about an hour<br /> 
res </span><span style="font-size: x-small;">&lt;</span><span style="font-family: &quot;Courier New&quot;,Courier,monospace; font-size: x-small;">- optimalf(port,probDrawdown,0.1,DD=0.2,horizon=12,calc.max=4,control=DEctrl)</span><br /> 
<br /> 
<span style="font-family: &quot;Courier New&quot;,Courier,monospace; font-size: x-small;"># Ruin-constrained Optimal f<br /> 
res </span><span style="font-family: &quot;Courier New&quot;,Courier,monospace; font-size: x-small;">&lt;</span><span style="font-family: &quot;Courier New&quot;,Courier,monospace; font-size: x-small;">- optimalf(port,probRuin,0.1,DD=0.2,horizon=4,control=DEctrl)<br /> 
<br /> 
# Drawdown-constrained Optimal f<br /> 
res </span><span style="font-family: &quot;Courier New&quot;,Courier,monospace; font-size: x-small;">&lt;</span><span style="font-family: &quot;Courier New&quot;,Courier,monospace; font-size: x-small;"><span style="font-family: &quot;Courier New&quot;,Courier,monospace; font-size: x-small;">- optimalf(port,probDrawdown,0.1,DD=0.2,horizon=4,control=DEctrl)</span><br /> 
</span><br /> 
</div> 
<div style='clear: both;'></div> 
</div>

<p> The <strong>project summary page</strong> you can find <a href="http://<?php echo $domain; ?>/projects/<?php echo $group_name; ?>/"><strong>here</strong></a>. </p>

</body>
</html>
