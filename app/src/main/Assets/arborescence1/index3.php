<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
define( '_JEXEC', 1 );
define('JPATH_BASE', "../../../" );   // should point to joomla root
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$mainframe = JFactory::getApplication('site');
/*include('lib/main.lib.php');
include('config.php');
$bdd = new PDO('mysql:host='.$BDD_hote.';dbname='.$BDD_nmDB, $BDD_user, $BDD_pass);*/
$db =& JFactory::getDBO();

function getCat($id)
{
$db =& JFactory::getDBO();
$req="SELECT id,nom,classe from sy0uk_categorie where id=".$id;
		$db->setQuery( $req);
			$rows = $db->loadObjectList();
		foreach($rows as $data)
		{
		$res['nom']=$data->nom;
		$res['classe']=$data->classe;
		}
return $res;
}


$request="SELECT cat.parent as parent_cat,cat.id as id_cat,cat.nom as nom_cat,
cours.id as id_cours,cours.nom as nom_cours,cours.type_cours as type_cours,cours.rappel as rappel_cours,
chap.id as id_chap,chap.nom as nom_chap,classe.id as id_classe,
classe.nom as nom_classe from sy0uk_cours as cours inner join sy0uk_chapitre as chap inner join sy0uk_classe as classe inner join sy0uk_categorie as cat
 ON cours.classe=classe.id AND cours.chapitre =chap.id AND chap.categorie =cat.id 
 where chap.valid=1 AND cat.valid=1 AND classe.valid=1 AND cours.valid=1 AND cours.active=1  order by classe.ordre,cours.rappel,cours.niveau";
 
 $db->setQuery( $request );
			$rows = $db->loadObjectList();
	foreach($rows as $data)
	{
	//classe
	if(!in_array($data->nom_classe, $res['nom_classe']))
	$res['nom_classe'][]=$data->nom_classe;
	if(!in_array($data->id_classe, $res['id_classe']))
	$res['id_classe'][]=$data->id_classe;
	//categorie
	if(!in_array($data->nom_cat, $res[$data->id_classe][$data->parent_cat]['nom_cat']))
	$res[$data->id_classe][$data->parent_cat]['nom_cat'][]=$data->nom_cat;
	if(!in_array($data->id_cat, $res[$data->id_classe][$data->parent_cat]['id_cat']))
	$res[$data->id_classe][$data->parent_cat]['id_cat'][]=$data->id_cat;
	
	
	
	//parent cat
	if(!in_array($data->parent_cat, $res['parent_cat']))
	$res['parent_cat'][]=$data->parent_cat;
	//cat
	if(!in_array($data->id_cat, $res['id_cats']))
	$res['id_cats'][]=$data->id_cat;
	//chapitre
	if(!in_array($data->nom_chap, $res[$data->id_cat]['nom_chap']))
	$res[$data->id_cat]['nom_chap'][]=$data->nom_chap;
	if(!in_array($data->id_chap, $res[$data->id_cat]['id_chap']))
	$res[$data->id_cat]['id_chap'][]=$data->id_chap;
	//cours
	if(!in_array($data->nom_cours, $res[$data->id_chap][$data->id_classe]['nom_cours']))
	$res[$data->id_chap][$data->id_classe]['nom_cours'][]=$data->nom_cours;
	if(!in_array($data->id_cours, $res[$data->id_chap][$data->id_classe]['id_cours']))
	$res[$data->id_chap][$data->id_classe]['id_cours'][]=$data->id_cours;	
	//type cours
	if(!in_array($data->type_cours, $res[$data->id_cours]['type_cours']))
	$res[$data->id_cours]['type_cours']=$data->type_cours;
	}
	
	//var_dump($res['parent_cat']);
 
?>
  <!-- 3 setup a container element -->

    <!-- in this example the tree is populated from inline HTML -->

	    <ul  id="navigation">
		<?php
	foreach($res['nom_classe'] as $key_classe => $nom_classe)
	{$id_classe=$res['id_classe'][$key_classe];
	?>
      <li class="toggleSubMenu"><span><?php echo $nom_classe;?></span>
        <ul class="subMenu">
		
	<?php
	
	
	foreach($res['parent_cat'] as $parent_cat)
	{//echo $parent_cat;
	if($parent_cat==0)
		{
	foreach($res[$id_classe][$parent_cat]['nom_cat'] as $key_cat => $nom_cat)
	{
	
	?>
	<li class="toggleSubMenu"><span><?php echo $nom_cat;?></span>
	<?php
	$id_cat=$res[$id_classe][$parent_cat]['id_cat'][$key_cat];
	
		?>
		
		
		<ul class="subMenu">
		  <?php
		  
		  foreach($res[$id_cat]['nom_chap'] as $key_chap => $nom_chap)
		  {
		  $id_chap=$res[$id_cat]['id_chap'][$key_chap];
		  ?>
		  <li class="toggleSubMenu chapitre"><span><?php echo $nom_chap;?></span>
		   <ul class="subMenu">
		   <?php
		  
		  foreach($res[$id_chap][$id_classe]['nom_cours'] as $key_cours => $nom_cours)
		  {$id_cours=$res[$id_chap][$id_classe]['id_cours'][$key_cours];
		  if($res[$id_cours]['type_cours']==3)
		  {
		  ?>
		  <li><a onclick="add_c(<?php echo $id_cours;?>,<?php echo $res[$id_cours]['type_cours'];?>)" class="linkcours" name="<?php echo $nom_cours;?>" id="<?php echo $id_cours;?>"><?php echo $nom_cours;?></a>
		  </li>
		  <?php
		  }
		  }
		   foreach($res[$id_chap][$id_classe]['nom_cours'] as $key_cours => $nom_cours)
		  {$id_cours=$res[$id_chap][$id_classe]['id_cours'][$key_cours];
		  if($res[$id_cours]['type_cours']!=3)
		  {
		  ?>
		  <li><a onclick="add_c(<?php echo $id_cours;?>,<?php echo $res[$id_cours]['type_cours'];?>)" class="linkcours" name="<?php echo $nom_cours;?>" id="<?php echo $id_cours;?>"><?php echo $nom_cours;?></a>
		  </li>
		  <?php
		  }
		  }
		  ?>
		  </ul>
		  </li>
		  <?php
		  }
		  ?>
		</ul>
		<?php	
	

		}
		}	
		else 
		{//echo $parent_cat;
		$catt=getCat($parent_cat);
		if($catt['classe']==$id_classe)
		{
		?>
		<li class="toggleSubMenu"><span><?php echo $catt['nom'];?></span>
		
		<?php
		}
		?>
		<ul class="subMenu">
		<?php
		foreach($res[$id_classe][$parent_cat]['nom_cat'] as $key_cat1 => $nom_cat1)
	{
	$id_cat1=$res[$id_classe][$parent_cat]['id_cat'][$key_cat1];
	?>
		<li class="toggleSubMenu"><span><?php echo $nom_cat1;?></span>
		
		<ul class="subMenu">
		  <?php
		  
		  foreach($res[$id_cat1]['nom_chap'] as $key_chap1 => $nom_chap)
		  {
		  $id_chap1=$res[$id_cat1]['id_chap'][$key_chap1];
		  ?>
		  <li class="toggleSubMenu chapitre"><span><?php echo $nom_chap;?></span>
		   <ul class="subMenu">
		   <?php
		  
		  foreach($res[$id_chap1][$id_classe]['nom_cours'] as $key_cours1 => $nom_cours)
		  {$id_cours1=$res[$id_chap1][$id_classe]['id_cours'][$key_cours1];
		  if($res[$id_cours1]['type_cours']==3)
		  {
		  ?>
		  <li><a onclick="add_c(<?php echo $id_cours1;?>,<?php echo $res[$id_cours1]['type_cours'];?>)" class="linkcours" name="<?php echo $nom_cours;?>" id="<?php echo $id_cours1;?>"><?php echo $nom_cours;?></a>
		  </li>
		  <?php
		  }
		  }
		  foreach($res[$id_chap1][$id_classe]['nom_cours'] as $key_cours1 => $nom_cours)
		  {$id_cours1=$res[$id_chap1][$id_classe]['id_cours'][$key_cours1];
		  if($res[$id_cours1]['type_cours']!=3)
		  {
		  ?>
		  <li><a onclick="add_c(<?php echo $id_cours1;?>,<?php echo $res[$id_cours1]['type_cours'];?>)" class="linkcours" name="<?php echo $nom_cours;?>" id="<?php echo $id_cours1;?>"><?php echo $nom_cours;?></a>
		  </li>
		  <?php
		  }
		  }
		  ?>
		  </ul>
		  </li>
		  <?php
		  }
		  ?>
		</ul>
		</li>
		<?php	
	
		
		
		
		
		}		
		?>
		</ul></li>
		<?php
		
		
		
		
		}		
		?>
      </li>
	 <?php
	 
	 }
	 
	 ?>
	 
	  </ul>
      </li>
	 <?php
	 }
	 ?>
    </ul>
	<script>
	function instruction(instr) {
if(instr!="")
{
var instr1=instr.split(";**;");
jQuery('#instruction .content').html("<h2>Instruction</h2>"+instr1[0]+"<h2>Réponse juste</h2>"+instr1[1]);
}
else
{
jQuery('#instruction .content').html("<h2>Instruction</h2>");
}
}
var setIntervalChrono;
var id_exo="";
jQuery(document).ready(function(){


});
	function add_c(id,id_cours){
	//svgCanvas.clear(); 
			
	if(setIntervalChrono)
clearInterval(setIntervalChrono);
	 id_cour=id;
	 var session=window.location.href.split(/#/)[1];
	
 jQuery.ajax({
    url : "export.php?cours="+id_cour,
    type: "POST",
    success: function(data, textStatus, jqXHR)
    {
	  //alert(data);
	 var cour=data.split("#**#");
	  var codehtml=cour[0];
	  var instr=cour[1];
	  var time=cour[2];
	  var imgJPG = jQuery(codehtml).find('.div_question img').attr('src');
	  /*if(id_cours==3)
	  {
	  jQuery('#divcours').html("");
	  //svgCanvas.setMode('image');
					svgCanvas.imageCours=imgJPG;
					svgCanvas.addimg();
	  }
	  else*/
	  if(id_cours==3)
	  codehtml=codehtml.replace("image-cours", "../image-cours");
	  
	  jQuery('#divcours').html(codehtml);
$('#divcours .chrono').tzineClock();
	    jQuery( "#divcours *" ).mousedown(function() {
	//alert('aa');
  jQuery(this).select();

});
	  //svgCanvas.clear();
	  //updateCanvas(true);
	   //alert(id_cour);
	   //alert(instr);
	   jQuery('#mettrenote').css('display','block');
	   //if(instr!="")
	   {
	    instruction(instr);
		}
	   //afficher_cacher('note','divcours1');
	   
	   //socket.emit('mouseupSVG',session+"#**#"+svgCanvas.getSvgString());		
	 socket.emit('cours',session+'#**#'+codehtml+'#**#'+id_cour+'#**#'+time);
	 //partage select
	 $('select').change(function(){
	 //alert(this.value);
	 jQuery.each(jQuery('#divcours').find('select'), function(key,val) {
	if(key==0)
	reponse=jQuery('#divcours').find('select')[key].value;
	else reponse=reponse+","+jQuery('#divcours').find('select')[key].value;
  })
	//alert(reponse);
	socket.emit('reponse',session+'#**#'+reponse+'#**#0#**#'+'select');
	 });
	 ////////
	 //partage de checkbox
	 $('input').change(function() {
	if(this.type=="checkbox"){
	jQuery.each(jQuery('#divcours').find('input[type="checkbox"]'), function(key,val) {
	if(key==0){
	if(jQuery('#divcours').find('input[type="checkbox"]')[key].checked==true)
	reponse=jQuery('#divcours').find('input[type="checkbox"]')[key].value;
	else
	reponse="0";
	}
	else
	{
	if(jQuery('#divcours').find('input[type="checkbox"]')[key].checked==true)
	reponse=reponse+","+jQuery('#divcours').find('input[type="checkbox"]')[key].value; 
	else
	reponse=reponse+",0";
	}
	});
	//alert(reponse);
	socket.emit('reponse',session+'#**#'+reponse+'#**#'+this.value+'#**#'+this.type);
	}
	 
	 });
	 //////
	 //partage de radio
	  $('input').click(function() {
	console.log(this.type);
	if(this.type=="radio"){
	jQuery.each(jQuery('#divcours').find('input[type="radio"]'), function(key,val) {
	if(key==0 || key==1){
	if(jQuery('#divcours').find('input[type="radio"]')[key].checked==true)
	{
	reponse=this.id;
	}
	}
	else 
	if(jQuery('#divcours').find('input[type="radio"]')[key].checked==true){
	reponse=reponse+","+this.id;
	}
  })
 // alert(reponse);
socket.emit('reponse',session+'#**#'+reponse+'#**#0#**#'+this.type);
	}
});
//////
//partage de zone text
	 $('input').keyup(function() {
       console.log(this.value);
	   jQuery.each(jQuery('#divcours').find('input[type="text"]'), function(key,val) {
	   if(key==0){
	   reponse=jQuery('#divcours').find('input[type="text"]')[key].value; 
	   }
	   else {
	   reponse=reponse+","+jQuery('#divcours').find('input[type="text"]')[key].value; 
	   }
	   })
	   //alert(reponse);
	   socket.emit('reponse',session+'#**#'+reponse+'#**#0#**#'+this.type);
});
//////
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
 
    }
});
//svgCanvas.clear();
//alert(svgCanvas.svgroot1); 
var svgclear='<svg width="1400" height="600" xmlns="http://www.w3.org/2000/svg">'+
 '<g>'+
  '<title>Layer 1</title>'+
 '</g>'+
'</svg>';
svgCanvas.setSvgString(svgclear);
}
(function(jQuery){
			jQuery(window).load(function(){
				
				jQuery(".exercice .subMenu").mCustomScrollbar({
					theme:"3d"
				});
				jQuery(".exercice .divcours").mCustomScrollbar({
					theme:"3d"
				});
				
			});
		})(jQuery);
    jQuery(document).ready( function () {
		jQuery(".exercice .subMenu").mCustomScrollbar({
					theme:"3d"
				});
				jQuery(".exercice .divcours").mCustomScrollbar({
					theme:"3d"
				});
        // On cache les sous-menus
        // sauf celui qui porte la classe "open_at_load" :
        jQuery("ul.subMenu:not('.open_at_load')").hide();
        // On selectionne tous les items de liste portant la classe "toggleSubMenu"
    
        // et on remplace l'element span qu'ils contiennent par un lien :
        jQuery("li.toggleSubMenu span").each( function () {
            // On stocke le contenu du span :
            var TexteSpan = $(this).text();
            $(this).replaceWith('<a href="" title="Afficher le sous-menu">' + TexteSpan + '</a>') ;
        } ) ;
    
        // On modifie l'evenement "click" sur les liens dans les items de liste
        // qui portent la classe "toggleSubMenu" :
        jQuery("li.toggleSubMenu > a").click( function () {
		
            // Si le sous-menu etait deja ouvert, on le referme :
            if ($(this).next("ul.subMenu:visible").length != 0) {
                $(this).next("ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") } );
            }
            // Si le sous-menu est cache, on ferme les autres et on l'affiche :
            else {
                //$("ul.subMenu").slideUp("normal", function () { $(this).parent().removeClass("open") } );
                $(this).next("ul.subMenu").slideDown("normal", function () { $(this).parent().addClass("open") } );
            }
            // On empêche le navigateur de suivre le lien :
            return false;
        });
    
    } ) ;
	</script>