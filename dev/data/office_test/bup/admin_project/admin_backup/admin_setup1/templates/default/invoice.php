<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Invoice</title>
<link href="templates/default/invoice.css" media="all" rel="stylesheet" />
</head>
<body>
<table style="font-family:Arial, Helvetica, sans-serif;color:#565656;font-size:13px;margin:2% auto;max-width:780px;line-height:1.2em;" width="90%">
	<tr>	 
    	<td>
            <table width="100%">
    
                <tr>	
                    <td width="50%"><h3><?php echo $invoice['title']; ?></h3></td>
                    <td></td>
                    <td width="36%"><img src="<?php echo $main->getThemeFolder(); ?>images/img_logo.png" width="100%;" height="auto" style="margin-bottom:10px;" /></td>
                </tr>
             
            </table>
        </td>
    </tr>
	<tr>	
    	<td>
            <table width="100%"> 
                <tr>	
                    <td width="50%" valign="bottom"><?php echo $client['clientName']; ?><br />T.a.v. <?php echo $client['accountperson']; ?><br />administratie</td>
                    <td></td>
                    <td width="26%"><div style="width:116px;float:right;">Oddsized <br/>Fultonstraat 77 <br />2562xc Den Haag</div></td>
                </tr>
            </table>
        </td>
    </tr>
	<tr>	
    	<td>
            <table width="100%">
    
                <tr>	
                    <td width="50%" valign="top"><?php echo $client['clientAddress']; ?><br /><?php echo $client['clientPostbox']; ?> <?php echo $client['clientCity']; ?></td>
                    <td></td>
                    <td width="26%"><div style="width:116px;float:right;"><p>Datum:<br/><?php echo $invoice['date']; ?></p><p>Factuur nr.:<br/><?php echo $invoice['invoiceID']; ?></p></div></td>
                </tr>
            
            </table>
        </td>
    </tr>
    <tr>	
    	<td>
            <table width="100%">
                <tr>	
                    <td>
                    	<p>
                    		Geachte Heer/Mevrouw,
                        </p>
                    	<p>
                        	<?php echo $invoice['text']; ?>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <?php if( is_array( $invoice['tasks'] ) ){ 
	
		// desc, price, hours, startdate, enddate, taxlow, taxhigh
		$pricetotal = 0;
		$taxlow = 0;
		$taxhigh = 0;
        $taxlowtotal = 0;
        $taxhightotal = 0;
	?>
    <tr>	
    	<td>
            <table id="calcbox" border="0" width="100%">
            	<tr class="titlerow"><td>Omschrijving</td><td width="80px" align="center">Prijs</td><td width="8%" align="center">Aantal</td><td width="110px" align="center"> Totaal</td></tr>
                <!-- variable rows -->
                <?php foreach( $invoice['tasks'] as $task ){ 
                
                	$tasktotalprice = $task['price'] * $task['hours'];
					
					if( $task['taxlow'] > 0 ){
						$taxlowtotal = $taxlowtotal + ( $tasktotalprice * ($task['taxlow']/100) );
						$taxlow = $task['taxlow'];
					}
					if( $task['taxhigh'] > 0 ){
						$taxhightotal = $taxhightotal + ( $tasktotalprice * ($task['taxhigh']/100) );
						$taxhigh = $task['taxhigh'];
					}
                	?>
                    
                	<tr class="unitrow"><td><?php echo $task['desc']; ?></td><td align="right">€ <?php echo $task['price']; ?></td><td style="padding-right:16px;" align="right"><?php echo $task['hours']; ?></td><td align="right">€ <?php echo $tasktotalprice; ?></td></tr>
                
				<?php 
					
					$pricetotal = $pricetotal + $tasktotalprice;
					
					} 
				?>
                
                <!-- end variable rows-->
                <tr class="subtotalrow"><td>Subtotaal</td><td> </td><td></td><td align="right">€ <?php echo $pricetotal; ?></td></tr>
                
                <?php if( $taxlowtotal > 0 ){ ?>
                <tr class="taxrow"><td>BTW <?php echo $taxlow; ?>%</td><td> </td><td></td><td align="right">€ <?php echo $taxlowtotal;//$tax = $pricetotal * 0.21; echo $tax; ?></td></tr>
                <?php } ?>
                <?php if( $taxhightotal > 0 ){ ?>
                <tr class="taxrow"><td>BTW <?php echo $taxhigh; ?>%</td><td> </td><td></td><td align="right">€ <?php echo $taxhightotal;//$tax = $pricetotal * 0.21; echo $tax; ?></td></tr>
                <?php } ?>
                <tr class="totalrow"><td>Totaal</td><td> </td><td></td><td align="right">€ <?php echo $pricetotal+$taxlowtotal+$taxhightotal; ?></td></tr>  
                
                
             </table>
        </td>
    </tr> 
    <?php } ?>
    <tr>	
    	<td>
            <table width="100%">
                <tr>	
                    <td>
                    <p>
                    Graag het verschuldigde bedrag binnen 14 dagen overmaken op IBAN nummer NL48 INGB 0009 5157 29 ten name van Oddsized in Den Haag. Voor vragen of opmerkingen ben ik te bereiken via onderstaande gegevens.
                    </p>
                    <p>Met vriendelijk groet, <br />Carl Müller</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="10%;">	
    	<td>
            <table align="center">
                <tr>	
                    <td align="center">
                        <p>
                            IBAN: NL48INGB0009515729 - BTW: 173951478 B01 - KVK: 27256460
                            <br/>oddsized.com - project@oddsized.org - 0641611661
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>