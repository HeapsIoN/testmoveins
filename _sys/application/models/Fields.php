<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Fields Class
 *
 * Nice fields outputting Class with Record Check
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2010 - 2015, Pelco Consulting Pty Ltd
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @class		Fields
 * @author		Pelco Consulting Pty Ltd
 * @copyright	Copyright (c) 2010 - 2015, Pelco Consulting Pty Ltd (http://lukepelgrave.com.au/)
 * @license		http://opensource.org/licenses/MIT	MIT License
 * @link		http://lukepelgrave.com.au
 * @since		Version 1.0.0
 */

class Fields extends Page {

// Master Options
var $formid		= '';	// ID for the form


// Watcher Settings
var $watchid	= '';	// Variable Columns used for watcher ID
var $watcher 	= '';	// The name of the field the form relates to
var $watchtag 	= '';	// The tag used for the watch form (jQuery variable)
var $watchclass	= '';

public function __construct()
	{
	parent::__construct();
	}


public function configure()
	{
	if($this->watcher!='')
		{
		$this->watchtag 	= ' oc-watch="'.$this->watcher.'"';
		$this->watchclass	= ' form-watcher';
		}
	}

public function text($lbl, $name, $id, $plh, $cls=NULL, $typ=NULL, $def=NULL, $req=NULL, $ron=NULL, $dis=NULL)
	{
	$tag = $this->watchtag;
	
	$t = $typ!=NULL && $typ!='' ? $typ : 'text';
	
	$name = $name=='' ? $id : $name;
	
	$v = isset($this->page->record[$name]) ? $this->page->record[$name] : $def;
	
	$cls = $cls!=NULL && $cls!='' ? $this->watchclass.' '.$cls : $this->watchclass;
	
	$def = $def!=NULL && $def!='' ? $def : '';
	
	if($req!=NULL && $req!='')
		{
		$cls .= ' required';
		$tag .= ' required';
		}
	
	if($ron!=NULL && $ron!='')
		{
		$cls .= ' readonly';
		$tag .= ' readonly="readonly"';
		}
	
	if($dis!=NULL && $dis!='')
		{
		$cls .= ' disabled';
		$tag .= ' disabled="disabled"';
		}
	
	if($lbl!='')
		{
		echo '<label for="'.$id.'" class="col-xs-12 col-sm-3 col-md-2 alg-xs-lft alg-rgt">'.$lbl.'</label>';
		}
	
	echo '<input type="'.$t.'" class="input col-xs-12 col-sm-9 col-md-4'.$cls.'"'.$tag.' id="'.$id.'" name="'.$name.'" placeholder="'.$plh.'" value="'.$v.'" />';	
	
	}

public function textarea($lbl, $name, $id, $plh, $req=NULL, $def=NULL, $cls=NULL, $ron=NULL, $dis=NULL)
	{
	$tag = $this->watchtag;
	
	$def = $def!=NULL && $def!='' ? $def : '';
	
	$v = isset($this->page->record[$name]) ? $this->page->record[$name] : $def;
	
	$cls = $cls!=NULL && $cls!='' ? $this->watchclass.' '.$cls : $this->watchclass;
	
	if($req!=NULL && $req!='')
		{
		$cls .= ' required';
		$tag .= ' required';
		}
	
	if($ron!=NULL && $ron!='')
		{
		$cls .= ' readonly';
		$tag .= ' readonly="readonly"';
		}
	
	if($dis!=NULL && $dis!='')
		{
		$cls .= ' disabled';
		$tag .= ' disabled="disabled"';
		}
	
	if($lbl!='')
		{
		echo '<label for="'.$id.'" class="col-xs-12 col-sm-3 col-md-2 alg-xs-lft alg-rgt">'.$lbl.'</label>';
		}
	
	echo '<div class="col-xs-12 col-sm-9 col-md-10 pad-none"><textarea class="form-control'.$cls.'"'.$tag.' id="'.$id.'" name="'.$name.'" placeholder="'.$plh.'">'.$v.'</textarea></div>';	
	}

public function button($lbl, $id, $form, $cls=NULL, $type=NULL, $trig=NULL)
	{
	$cls = $cls!=NULL && $cls!='' ? ' '.$cls : '';
	
	$type = $type!=NULL ? $type : 'button';
	
	$trig = $trig!=NULL ? $trig : 'form-button';
	
	echo '<button type="'.$type.'" class="'.$trig.' btn col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-2'.$cls.'" id="'.$id.'" smp-form="'.$form.'">'.$lbl.'</button>';	
	
	}

public function toggle($lbl, $name, $id, $def=NULL, $lbla=NULL, $vala=NULL, $lblb=NULL, $valb=NULL, $wcls=NULL)
	{
	
	// $name, $optalbl, $optaval, $optblbl, $optbval, $value, $id
	
	$lbla = $lbla==NULL ? 'Yes' : $lbla;
	$vala = $vala==NULL ? '1' 	: $vala;
	$lblb = $lblb==NULL ? 'No' 	: $lblb;
	$valb = $valb==NULL ? '2' 	: $valb;
	
	$def = $def!='' && $def!=NULL ? $def : $vala;
	
	$v = isset($this->page->record[$name]) ? $this->page->record[$name] : $def;
	
	$tlbl = $lbla;
	$rwcls = '';
	$rlcls = '';
	$wcls = $wcls!=NULL ? $wcls : 'col-xs-12 col-sm-9 col-md-10 pad-none';
	
	if($v==$valb)
		{
		$tlbl = $lblb;
		$rwcls = ' nf-tgl-off'; // twoWayToggleOff
		$rlcls = ' nf-tgl-swd'; //twoWayToggleSwitched
		}
	
	if($lbl!='')
		{
		echo '<label for="'.$id.'" class="col-xs-12 col-sm-3 col-md-2 alg-xs-lft alg-rgt">'.$lbl.'</label>';
		}
	
	echo '<div class="'.$wcls.'"><span class="nf-tgl-wrp"><input type="hidden" class="nf-tgl-val nf-hdn" id="'.$id.'" name="'.$name.'" value="'.$v.'" /><button type="button" class="nf-tgl'.$rwcls.'" data-rel="'.$id.'" data-opta="'.$lbla.'" data-optb="'.$lblb.'" data-vala="'.$vala.'" data-valb="'.$valb.'"><span class="nf-tgl-lbl'.$rlcls.'">'.$tlbl.'</span></button></span></div>';
	}

public function radio($lbl, $id, $name, $opts, $class=NULL, $lcls=NULL, $wcls=NULL)
	{
	$opts = !is_array($opts) && isset($this->page->opts[$opts]) ? $this->page->opts[$opts] : $opts;
	$v = isset($this->page->record[$name]) ? $this->page->record[$name] : '';
	$cls = $class!=NULL ? ' '.$class : '';
	$name = $name!='' ? ' name="'.$name.'"' : '';
	
	$wcls = $wcls!=NULL ? $wcls : 'col-xs-12 col-sm-9 col-md-10 pad-none';
	$lcls = $lcls!=NULL ? $lcls : 'col-xs-12 col-sm-3 col-md-2 alg-xs-lft alg-rgt';
	
	if($lbl!='')
		{
		echo '<label for="'.$id.'" class="'.$lcls.'">'.$lbl.'</label>';
		}
	
	// First we output the wrapper and the hidden field
	echo '<div class="'.$wcls.'"><span class="nf-rad"><input type="text" '.$name.' id="'.$id.'" value="'.$v.'" class="nf-rad-fld" />';
	
	// Then for each option, we output the radio selector
	foreach($opts as $k => $l)
		{
		$s = $v==$k ? '<span class="nf-rad-sel"></span>' : '';
		echo '<button type="button" class="nf-rad-opt'.$cls.'" opt-val="'.$k.'" opt-fld="'.$id.'"><span class="nf-rad-box">'.$s.'</span><span class="nf-rad-lbl">'.$l.'</span></button>';
		}

	// Then we close the wrapper for the group
    echo '</span></div>';	
	}

public function checkbox($fld, $lbl, $val, $class=NULL)
	{
	$v = isset($this->page->record[$fld]) ? $this->page->record[$fld] : '';
	
	$chkd = ' disabled="disabled"';
	$icn = '';
	$wrp = '  is-chkd="n"';
	$cls = $class!=NULL ? ' '.$class : '';
	
	if($v==$val)
		{
		$chkd = '';
		$icn = ' nf-chk-sel';
		$wrp = '  is-chkd="y"';
		}
		
	echo '<div class="col-xs-12 pad-none"><button type="button" class="nf-chk'.$cls.'"'.$wrp.'><input class="nf-chk-fld" type="hidden" value="'.$val.'" name="'.$fld.'" id="'.$fld.'"'.$chkd.'><span class="nf-chk-icn'.$icn.'"></span><span class="nf-chk-lbl">'.$lbl.'</span></button></div>';	
	}

public function checkset($lbl, $fld, $opts, $class=NULL)
	{
	$opts = !is_array($opts) && isset($this->page->opts[$opts]) && is_array($this->page->opts[$opts]) ? $this->page->opts[$opts] : $opts;
	
	$vals = isset($this->page->record[$fld]) ? $this->page->record[$fld] : array();
	
	$cls = $class!=NULL ? ' '.$class : '';
	
	if($lbl!='')
		{
		echo '<label for="'.$id.'" class="col-xs-12 col-sm-3 col-md-2 alg-xs-lft alg-rgt">'.$lbl.'</label>';
		}
	
	echo '<div class="col-xs-12 col-sm-9 col-md-10">';
	
	if(!empty($opts))
		{
		foreach($opts as $v => $lbl)
			{
			$chkd = '';
			$icn = '';
			$wrp = '  is-chkd="n"';
			
			
			if(in_array($v, $vals))
				{
				$chkd = ' checked="checked"';
				$icn = ' nf-chk-sel';
				$wrp = '  is-chkd="y"';
				}
			
			echo '<button type="button" class="nf-chk'.$cls.'"'.$wrp.'><input class="nf-chk-fld" type="checkbox" value="'.$v.'" name="'.$fld.'[]" id="'.$fld.'-'.$v.'"'.$chkd.'><span class="nf-chk-icn'.$icn.'"></span><span class="nf-chk-lbl">'.$lbl.'</span></button>';
			}
		}
	
	echo '</div>';
	}

public function select($lbl, $name, $opts, $lcls, $id, $cucls, $empty)
	{
	$opts = !is_array($opts) && isset($this->page->opts[$opts]) && is_array($this->page->opts[$opts]) ? $this->page->opts[$opts] : $opts;
	
	$value = isset($this->page->record[$name]) ? $this->page->record[$name] : '';
	
	$first = array();
	foreach($opts as $k => $v)
		{
		if(empty($first) || !isset($first['id'])  || !isset($first['label']))
			{
			$first['id'] = $k;
			$first['label'] = $v;
			}
		}
	
	$value = $empty=='' && $value=='' && isset($first['id']) ? $first['id'] : $value;
	$label = isset($opts[$value]) ? $opts[$value] : '';
	
	if($lbl!='')
		{
		echo '<label for="'.$id.'" class="col-xs-12 col-sm-3 col-md-2 alg-xs-lft alg-rgt">'.$lbl.'</label>';
		}
	
	echo '<span class="nf-sel '.$lcls.'">
		<input type="text" name="'.$name.'" id="'.$id.'" value="'.$value.'" class="nf-sel-val" my-val="'.$value.'" new-val="'.$value.'" new-lbl="'.$label.'" autocomplete="off" />';
	
	$cls = $cucls!='' ? ' '.$cucls : '';
	
	if(isset($opts[$value]))
		{
		
		echo '<button type="button" class="nf-sel-cur'.$cls.'">'.$opts[$value].'<span class="nf-sel-arw fa fa-angle-down"></span></button>'; 
		}
	else
		{
		if($empty!='')
			{
			echo '<span class="nf-sel-cur'.$cls.'">[ '.$empty.' ]<span class="nf-sel-arw fa fa-angle-down"></span></span>'; 	
			}
		elseif(isset($first['label']))
			{
			echo '<span class="nf-sel-cur'.$cls.'">'.$first['label'].'<span class="nf-sel-arw fa fa-angle-down"></span></span>';
			}
		}
	
	echo '<span class="nf-sel-lst">';
	
	if($empty!='')
		{
		$c = $value=='' ? ' nf-sel-lbl' : '';
		echo '<button type="button" class="nf-sel-opt nf-sel-emp'.$c.'" opt-val="" opt-lbl="[ '.$empty.' ]">[ '.$empty.' ]</button>';	
		}
	
	if(!empty($opts))
		{
		foreach($opts as $k => $v)
			{
			$c = $k==$value ? ' nf-sel-lbl' : '';
			echo '<button type="button" class="nf-sel-opt'.$c.'" opt-val="'.$k.'" opt-lbl="'.$v.'">'.$v.'</button>';	
			}
		}
	
	echo '</span></span>';	
	}

public function fileinput($name, $id, $fcls=NULL, $lcls=NULL)
	{
	$fcls = $fcls!=NULL ? ' '.$fcls : '';
	$lcls = $lcls!=NULL ? ' '.$lcls : '';
	echo '<span class="nf-fle"><input type="file" name="'.$name.'" id="'.$id.'" class="nf-fle-inp'.$fcls.'" size="20" /><input type="text" class="nf-fle-ttl'.$lcls.'" readonly="readonly" id="filetitle" name="filetitle" placeholder="Please select your file" /><span class="nf-fle-brs">Browse</span><span class="nf-fle-pro" id="'.$id.'-progress"><span class="progress-bar progress-bar-success"></span></span></span>';
	}

public function filedrop($name, $id, $fcls=NULL, $lcls=NULL)
	{
	$fcls = $fcls!=NULL ? ' '.$fcls : '';
	$lcls = $lcls!=NULL ? ' '.$lcls : '';
	
	echo '
<span class="nf-fle">
	<input type="file" name="'.$name.'" id="'.$id.'" class="nf-fle-inp'.$fcls.'" size="20" />
	<input type="text" class="nf-fle-ttl'.$lcls.'" readonly="readonly" id="'.$id.'Title" name="'.$name.'title" placeholder="Please select your file" />
	<span class="nf-fle-brs">Browse</span>
	<span class="nf-fle-drp" id="'.$id.'Dropzone">Drag and Drop File/s Here</span>
	<span class="nf-fle-pro" id="'.$id.'Progress">
		<span class="nf-fle-bar"></span>
	</span>
</span>';	
	}

}
