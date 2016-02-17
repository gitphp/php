<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="/Public/Js/prototype.lite.js" type="text/javascript"></script>
    <script src="/Public/Js/moo.fx.js" type="text/javascript"></script>
    <script src="/Public/Js/moo.fx.pack.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Style/skin.css" />
    <script type="text/javascript">
        window.onload = function () {
            var contents = document.getElementsByClassName('content');
            var toggles = document.getElementsByClassName('type');

            var myAccordion = new fx.Accordion(
            toggles, contents, {opacity: true, duration: 400}
            );
            myAccordion.showThisHideOpen(contents[0]);
            for(var i=0; i<document .getElementsByTagName("a").length; i++){
                var dl_a = document.getElementsByTagName("a")[i];
                    dl_a.onfocus=function(){
                        this.blur();
                    }
            }
        }
    </script>
</head>

<body>
    <table width="100%" height="280" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEF2FB">
        <tr>
            <td width="182" valign="top">
                <div id="container">
                
                
<?php foreach($data as $v):?>
    <h1 class="type"><a href="javascript:void(0)"><?php echo $v['p_name']?></a></h1>
    <div class="content">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><img src="/Public/Images//menu_top_line.gif" width="182" height="5" /></td>
            </tr>
        </table>
        <ul class="RM">
        <?php foreach($v['child'] as $vv):?>
            <li><a href="<?php echo U($vv['p_cname'].'/'.$vv['p_aname']);?>" target="main"><?php echo $vv['p_name']?></a></li>
        	<!--  	<?php foreach($vv['child'] as $vvv):?>
            			<li><a href="<?php echo U($vvv['p_cname'].'/'.$vvv['p_aname']);?>" target="main"><?php echo '---',$vvv['p_name']?></a></li>
        			<?php endforeach;?>	
        	-->
        <?php endforeach;?>
        </ul>
    </div>
<?php endforeach;?>
                    
         
                </div>
            </td>
        </tr>
    </table>
</body>
</html>