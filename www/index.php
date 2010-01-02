
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

<pre>
# Load the LSPM package
library(LSPM)

# Multiple strategy example (data found on pp. 84-87)
trades <- cbind(
 c(-150,-45.33,-45.33,rep(13,5),rep(79.67,3),136),
 c(253,-1000,rep(-64.43,3),253,253,448,rep(-64.43,3),253),
 c(533,220.14,220.14,-500,533,220.14,799,220.14,-325,220.14,533,220.14) )
probs <- c(rep(0.076923077,2),0.153846154,rep(0.076923077,9))
 
# Create a Leverage Space Portfolio object
port <- lsp(trades,probs)

# DEoptim parameters (see ?DEoptim)
# NP=30        (10 * number of strategies)
# itermax=100  (maximum number of iterations)
DEctrl <- list(NP=30,itermax=100)

# Unconstrainted Optimal f (results on p. 87)
res <- optimalf(port,control=DEctrl)

# Drawdown-constrained Optimal f (results on p. 137)
# Since horizon=12, this optimization will take about an hour
res <- optimalf(port,probDrawdown,0.1,DD=0.2,horizon=12,calc.max=4,control=DEctrl)

# Ruin-constrained Optimal f
res <- optimalf(port,probRuin,0.1,DD=0.2,horizon=4,control=DEctrl)

# Drawdown-constrained Optimal f
res <- optimalf(port,probDrawdown,0.1,DD=0.2,horizon=4,control=DEctrl)
</pre>

<p> The <strong>project summary page</strong> you can find <a href="http://<?php echo $domain; ?>/projects/<?php echo $group_name; ?>/"><strong>here</strong></a>. </p>

</body>
</html>
