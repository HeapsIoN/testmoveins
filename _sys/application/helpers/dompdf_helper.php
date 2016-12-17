<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $stream=TRUE, $orientation=NULL) 
{
    require_once("dompdf/dompdf_config.inc.php");
    
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
	if($orientation!=NULL)
		{
		// landscape
		$page = $orientation=='landscape' ? array(0,0,842,596) : array(0,0,596,842);
		
		$dompdf->set_paper('a4', $orientation);
		}	
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf");
    } else {
        return $dompdf->output();
    }
}

