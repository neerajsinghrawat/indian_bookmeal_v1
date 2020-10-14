<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
        <!-- <title>Message from {shop_name}</title> -->
        
        
        <style> @media only screen and (max-width: 300px){ 
                body {
                    width:218px !important;
                    margin:auto !important;
                }
                .table {width:195px !important;margin:auto !important;}
                .logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto !important;display: block !important;}      
                span.title{font-size:20px !important;line-height: 23px !important}
                span.subtitle{font-size: 14px !important;line-height: 18px !important;padding-top:10px !important;display:block !important;}        
                td.box p{font-size: 12px !important;font-weight: bold !important;}
                .table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr { 
                    display: block !important; 
                }
                .table-recap{width: 200px!important;}
                .table-recap tr td, .conf_body td{text-align:center !important;}    
                .address{display: block !important;margin-bottom: 10px !important;}
                .space_address{display: none !important;}   
            }
    @media only screen and (min-width: 301px) and (max-width: 500px) { 
                body {width:308px!important;margin:auto!important;}
                .table {width:285px!important;margin:auto!important;}   
                .logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}    
                .table-recap table, .table-recap thead, .table-recap tbody, .table-recap th, .table-recap td, .table-recap tr { 
                    display: block !important; 
                }
                .table-recap{width: 295px !important;}
                .table-recap tr td, .conf_body td{text-align:center !important;}
                
            }
    @media only screen and (min-width: 501px) and (max-width: 768px) {
                body {width:478px!important;margin:auto!important;}
                .table {width:450px!important;margin:auto!important;}   
                .logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}            
            }
    @media only screen and (max-device-width: 480px) { 
                body {width:308px!important;margin:auto!important;}
                .table {width:285px;margin:auto!important;} 
                .logo, .titleblock, .linkbelow, .box, .footer, .space_footer{width:auto!important;display: block!important;}
                
                .table-recap{width: 295px!important;}
                .table-recap tr td, .conf_body td{text-align:center!important;} 
                .address{display: block !important;margin-bottom: 10px !important;}
                .space_address{display: none !important;}   
            }
</style>

    </head>
    <body style="-webkit-text-size-adjust:none;background-color:#fff;width:650px;font-family:Open-sans, sans-serif;color:#555454;font-size:13px;line-height:18px;margin:auto">
        <table class="table table-mail" style="width:100%;margin-top:10px;-moz-box-shadow:0 0 5px #afafaf;-webkit-box-shadow:0 0 5px #afafaf;-o-box-shadow:0 0 5px #afafaf;box-shadow:0 0 5px #afafaf;filter:progid:DXImageTransform.Microsoft.Shadow(color=#afafaf,Direction=134,Strength=5)">
            <tr>
                <td class="space" style="width:20px;padding:7px 0">&nbsp;</td>
                <td align="center" style="padding:7px 0">
                    <table class="table" bgcolor="#ffffff" style="width:100%">
                        <tr>
                            <td align="center" class="logo" style="border-bottom:4px solid #333333;padding:7px 0">
                                <a href="<?php //echo $url; ?>" style="color:#337ff1">
                                    <img src="http://kaarma.co.uk/image/setting/16008571965f6b246c5a81b.png" style="width: 210px;height: 60px;" />
                                </a>
                            </td>
                        </tr>

                     <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        
                            <td width="10%">&nbsp;</td>
                            <td width="80%" align="left" valign="top">
                                <font style="font-family: Verdana, Geneva, sans-serif; color:#666766; font-size:13px; line-height:21px">
                               
                               <?php echo !empty($emailContent) ? $emailContent : ''; ?>
                               
                                                             </font></td>
                                    <td width="10%">&nbsp;</td>
                                </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td align="right" valign="top"><table width="108" border="0" cellspacing="0" cellpadding="0">
                                         
                                            <tr>
                                                <td align="center" valign="middle" bgcolor=""&nbsp;</td>
                                            </tr>
                                          
                                            <tr>
                                                <td height="10" align="center" valign="middle" bgcolor="">  </td>
                                            </tr>
                                        </table></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table></td>
                        </tr>
                         

<tr>
    <td class="space_footer" style="padding:0!important">&nbsp;</td>
</tr>


                        <tr>
                            <td class="space_footer" style="padding:0!important">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="footer" style="border-top:4px solid #333333;padding:7px 0">
                                <span> © <?php echo date('Y'); ?> <a href="<?php //echo $url; ?>" style="color:#337ff1"><?php echo $setting->site_title; ?></a> All Rights Reserved</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="space" style="width:20px;padding:7px 0">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
