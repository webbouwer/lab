<?php
include( '../net/wp-load.php' );
include( '../net/wp-blog-header.php' );
if( !is_user_logged_in() || !current_user_can('manage_options') ) {
	header("location: http://oddsized.com/net/login");
}
require_once('assets/main.php'); 

$main = new main;

$main->page = basename($_SERVER['PHP_SELF']);
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Factuur</title>
</head>
<style>

#calcbox tr td
{
padding:2px 0px;
}

#calcbox tr.titlerow td
{
font-weight:bold;
padding:2px 0px;
}

#calcbox tr.unitrow td
{
padding:0px 0px 4px;
}
#calcbox tr.subtotalrow td:last-child
{
padding:4px 0px;
border-top:1px solid #565656;
}
#calcbox tr.taxrow td
{
padding:0px 0px 0px;
}
#calcbox tr.totalrow td
{
font-weight:bold;
padding:6px 0px 2px;
}
#calcbox tr.totalrow td:last-child
{
border-top:1px solid #565656;
}
</style>
<body> 


<?php


	echo $main->page;
 if( isset($_GET['iid']) && $invoice = $main->getInvoiceById($_GET['iid']) ){
	print_r($invoice);
	
}
?>

<table style="font-family:Arial, Helvetica, sans-serif;color:#565656;font-size:13px;margin:2% auto;max-width:780px;line-height:1.2em;" width="90%">
	<tr>	
    	<td>
            <table width="100%">
    
                <tr>	
                    <td width="50%"><h3>Factuur Webdesign & Ontwikkeling</h3></td>
                    <td></td>
                    <td width="36%"><img src="https://oddsized.com/site/wp-content/uploads/2017/05/img_logo.png" width="100%;" height="auto" style="margin-bottom:10px;" /></td>
                </tr>
            
            </table>
        </td>
    </tr>
	<tr>	
    	<td>
            <table width="100%">
                <tr>	
                    <td width="50%" valign="bottom">Misti<br />T.a.v. Jan Jansen<br />administratie</td>
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
                    <td width="50%" valign="top">Amstelplein 1 <br />2022 EM Amsterdam</td>
                    <td></td>
                    <td width="26%"><div style="width:116px;float:right;"><p>Datum:<br/> 01-01-2017 </p><p>Factuur nr.:<br/> 1800237</p></div></td>
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
                        	Bij deze het factuur betreffende de webdesign en ontwikkelings werkzaamheden voor BIGCOMPANY.
                    	</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>	
    	<td>
            <table id="calcbox" border="0" width="100%">
            	<tr class="titlerow"><td>Omschrijving</td><td width="80px" align="center">Prijs</td><td width="8%" align="center">Aantal</td><td width="110px" align="center"> Totaal</td></tr>
                <!-- variable rows-->
                <tr class="unitrow"><td>Webdesign & ontwikkeling</td><td align="right">€ 56,00</td><td style="padding-right:16px;" align="right">8</td><td align="right">€ 448,00</td></tr>
                <!-- end variable rows-->
                <tr class="subtotalrow"><td>Subtotaal</td><td> </td><td></td><td align="right">€ 1,008.00</td></tr>
                <tr class="taxrow"><td>BTW 21 %</td><td> </td><td></td><td align="right">€ 1,008.00</td></tr>
                <tr class="totalrow"><td>Totaal</td><td> </td><td></td><td align="right">€ 1,008.00</td></tr>  
             </table>
        </td>
    </tr> 
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

<?php } ?>
</body>
</html>
