<div class="col-xs-12 col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 pad-none">
<h1><?php $this->page->heading('pagetitle'); ?></h1>
<div class="col-xs-12">
	<p>Click on a log item to expand or collapse the request data and response.</p>
<?php
if(!empty($this->loggers->actions))
	{
	foreach($this->loggers->actions as $action)
		{
	?>
    <div class="col-xs-12 pad-none">
    	<h2 class="txt-1 bg-3 pad-lr col-xs-12 txt-md lh-60 cur-pnt log-record">
			<?php echo $action['stormanrequest'].' @ '.date('H:i:s', strtotime($action['stormantime'])).' on '.date('jS M, Y', strtotime($action['stormantime'])); ?>
        </h2>
        <h2 class="txt-1 bg-3 pad-lr col-xs-12 mrg-none txt-sm lh-50 log-data">Request Was</h2>
        <pre class="col-xs-12 pad-none mrg-none txt-xs log-data">
			<?php print_r(json_decode($action['stormanparameters'], true)); ?>
		</pre>
        <h2 class="txt-1 bg-3 pad-lr col-xs-12 mrg-none txt-sm lh-50 log-data">Result Was</h2>
        <pre class="col-xs-12 pad-none mrg-none txt-xs log-data">
        	<?php print_r(json_decode($action['stormanresponse'], true)); ?>
        </pre>
    </div>
    <?php		
		}
	}
?>
</div>
</div>
<script type="text/javascript">
$('.log-record').on('click', function(){$(this).parent('div').children('.log-data').slideToggle(350)});
</script>