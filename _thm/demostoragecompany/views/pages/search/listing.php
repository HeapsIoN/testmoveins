<div class="col-xs-12 mrg-t-md" id="list-body">
	<?php
	if(!empty($this->search->result))
		{
		$this->search->link = substr($this->search->link, -1)!='/' ? $this->search->link.'/' : $this->search->link;
		
		$bg = 'bg-vlg-grey';
		foreach($this->search->result as $row)
			{
		?>
		<div class="list-row col-xs-12 pad-none txt-drk-grey <?php echo $bg; ?>">
		<?php
			foreach($this->search->columns as $column => $settings)
				{
				$emp = isset($settings['empty']) && $settings['empty']!='' ? $settings['empty'] : 'Data Missing';
				$val = isset($row[$column]) && $row[$column]!='' ? $row[$column] : $emp;
				
				switch($settings['type'])
					{
					case 'text':
	?>
	<a href="/<?php echo $this->search->link.$row[$this->search->index]; ?>" class="list-col lh-50 alg-lt txt-drk-grey col-xs-12 col-sm-<?php echo $settings['width']; ?>">
		<span class="col-xs-12"><?php echo $val; ?></span>
	</a>
	<?php				
					break;
					case 'currency':
	?>
	<a href="/<?php echo $this->search->link.$row[$this->search->index]; ?>" class="list-col lh-50 alg-lt txt-drk-grey col-xs-12 col-sm-<?php echo $settings['width']; ?>">
		<span class="col-xs-12">$<?php echo $val; ?></span>
	</a>
	<?php				
					break;
					case 'date':
					
					$val = isset($settings['format']) ? date($settings['format'], strtotime($val)) : date('jS M, Y', strtotime($val));
	?>
	<a href="/<?php echo $this->search->link.$row[$this->search->index]; ?>" class="list-col lh-50 alg-rt txt-drk-grey col-xs-12 col-sm-<?php echo $settings['width']; ?>">
		<span class="col-xs-12"><?php echo $val; ?></span>
	</a>
	<?php				
					break;
					case 'udate':
					$val = isset($settings['format']) ? date($settings['format'], $val) : date('jS M, Y', $val);
	?>
	<a href="/<?php echo $this->search->link.$row[$this->search->index]; ?>" class="list-col lh-50 alg-rt txt-drk-grey col-xs-12 col-sm-<?php echo $settings['width']; ?>">
		<span class="col-xs-12"><?php echo $val; ?></span>
	</a>
	<?php				
					break;
					case 'ordering':
					//echo '<pre>';die(print_r($settings));
					$col = isset($settings['display']) ? $settings['display'] : $column;
					$val = isset($row[$col]) ? $row[$col] : $emp;
					$chk = isset($settings['check']) ? $settings['check'] : '';
					$i	= '';
					
					if($chk!='' && $row[$chk]!='' && $row[$chk]!='0')
						{
						$ind = isset($row[$settings['indent']]) && $row[$settings['indent']]!='' && $row[$settings['indent']]!='0' ? $row[$settings['indent']] : '';
						$i = '<i class="fa fa-level-up fa-list-icn fa-list-ind-'.$c.'"></i>';
						}					
	?>
	<a href="/<?php echo $this->search->link.$row[$this->search->index]; ?>" class="list-col lh-40 alg-lt txt-drk-grey col-xs-12 col-sm-<?php echo $settings['width']; ?>">
		<span class="col-xs-12"><?php echo $i.$val; ?></span>
	</a>
	<?php				
					break;
					case 'switcher':
					$icn = $val==1 ? '<span class="col-xs-12 pad-none lh-50 fa fa-circle txt-green list-switcher cur-pnt"></span>' : '<span class="col-xs-12 pad-none lh-50 fa fa-circle txt-pink list-switcher cur-pnt"></span>';
	?>
	<span class="list-col lh-50 alg-cr txt-drk-grey col-xs-12 col-sm-<?php echo $settings['width']; ?> pad-none" my-val="<?php echo $val; ?>" my-col="<?php echo $column; ?>" my-tbl="<?php echo $this->search->table; ?>">
		<span class="col-xs-12 list-switcher pad-none"><?php echo $icn; ?></span>
	</span>
	<?php				
					break;
					case 'isset':
					$icn = $val!=$emp ? '<span class="col-xs-12 pad-none lh-50 fa fa-circle txt-green list-switcher cur-pnt"></span>' : '<span class="col-xs-12 pad-none lh-50 fa fa-circle txt-pink list-switcher cur-pnt"></span>';
	?>
	<span class="list-col lh-50 alg-cr txt-drk-grey col-xs-12 col-sm-<?php echo $settings['width']; ?> pad-none" my-val="<?php echo $val; ?>" my-col="<?php echo $column; ?>" my-tbl="<?php echo $this->search->table; ?>">
		<span class="col-xs-12 list-switcher pad-none"><?php echo $icn; ?></span>
	</span>
	<?php				
					break;
					}	
	
				}
		?>
		</div>
		<?php
		
			$bg = $bg=='bg-vlg-grey' ? 'bg-lgt-grey' : 'bg-vlg-grey';
			}
		}
	else
		{
		if($this->search->searched!='1')
			{
		?>
        <span class="col-xs-12 lh-50 font-mdm txt-uc alg-cr txt-red"><?php echo $this->search->no_results; ?></span>
        <?php		
			}
		else
			{
		?>
        <span class="col-xs-12 lh-50 font-mdm txt-uc alg-cr txt-red"><?php echo $this->search->no_records; ?></span>
        <?php
			}
		}		
	?>
</div>
