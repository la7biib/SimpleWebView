<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
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


$request="SELECT cours.id as id_cours,cours.nom as nom_cours,comp.id as id_comp,comp.nom as nom_comp,classe.id as id_classe,
classe.nom as nom_classe from sy0uk_cours as cours inner join sy0uk_competence as comp inner join sy0uk_classe as classe
 ON cours.classe=classe.id AND cours.competence like concat('%\"',comp.id,'\"%') 
 where comp.valid=1 AND classe.valid=1 AND cours.valid=1 AND cours.active=1  order by classe.ordre,cours.niveau,cours.rappel";
 
 $db->setQuery( $request );
			$rows = $db->loadObjectList();
	foreach($rows as $data)
	{
	//echo $data->nom_comp ."<br>";
	if(!in_array($data->nom_comp, $res['nom_comp']))
	$res['nom_comp'][]=$data->nom_comp;
	if(!in_array($data->id_comp, $res['id_comp']))
	$res['id_comp'][]=$data->id_comp;
	if(!in_array($data->nom_classe, $res['nom_classe']))
	$res['nom_classe'][]=$data->nom_classe;
	if(!in_array($data->id_classe, $res['id_classe']))
	$res['id_classe'][]=$data->id_classe;
	if(!in_array($data->nom_cours, $res[$data->id_comp][$data->id_classe]['nom_cours']))
	$res[$data->id_comp][$data->id_classe]['nom_cours'][]=$data->nom_cours;
	if(!in_array($data->id_cours, $res[$data->id_comp][$data->id_classe]['id_cours']))
	$res[$data->id_comp][$data->id_classe]['id_cours'][]=$data->id_cours;	
	}
	
	//var_dump($res);
 
?>
  <!-- 3 setup a container element -->

    <!-- in this example the tree is populated from inline HTML -->

	    <ul  id="navigation">
		<?php
	$index_comp=0;
	foreach($res['nom_comp'] as $nom_comp)
	{
	?>
      <li class="toggleSubMenu"><span><?php echo $nom_comp;?></span>
        <ul class="subMenu">
		
	<?php
	$index_classe=0;
	foreach($res['nom_classe'] as $nom_classe)
	{
	?>
      <li class="toggleSubMenu"><span><?php echo $nom_classe;?></span>
        <ul class="subMenu">
		  <?php
		  
		 // echo "<li>".$res['id_comp'][$index_comp]."  ".$res['id_classe'][$index_classe]."</li>";
		  $index_cours=0;
		  foreach($res[$res['id_comp'][$index_comp]][$res['id_classe'][$index_classe]]['nom_cours'] as $nom_cours)
		  {$id_cours=$res[$res['id_comp'][$index_comp]][$res['id_classe'][$index_classe]]['id_cours'][$index_cours];
		  ?>
		  <li><a onclick="add_c(<?php echo $id_cours;?>)" class="linkcours" name="<?php echo $nom_cours;?>" id="<?php echo $id_cours;?>"><?php echo $nom_cours;?></a>
		  </li>
		  <?php
		  $index_cours++;
		  }?>
        </ul>
      </li>
	 <?php
	 $index_classe++;
	 }?>
	 
	  </ul>
      </li>
	 <?php
	 $index_comp++;
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
jQuery(".li_eval > a").mousedown(function(){
id_evaluation=$(this).parent().attr('id');
if(setIntervalChrono)
clearInterval(setIntervalChrono);
var seconds = 30;
$('.tab_intro .chrono').html('');
var codehtml="<table class='tab_intro'><tr><td><div class='intro'><div>Vous allez commencer une session d'évaluation</div>";
codehtml+="<div>Votre coach vous donnera une série d'exercices et de consignes</div>";
var nb_second=jQuery(this).parent().children().children().children().children().children(".linkcours").eq(0).attr('nb_child');
var minute =parseInt (nb_second * 300/60);

codehtml+="<div>Elle durera "+minute+" minutes et démarrera dans :</div></div></td><td><div class='chrono'><div class='start'>Démarrer</div></div></td></tr></table>";
jQuery('#divcours').html(codehtml);

socket.emit('cours',session+'#**#'+codehtml+'#**#'+id_cour+'#**#'+'intro'+'#**#'+id_evaluation);


id_exo=jQuery(this).parent().children().children().children().children().children(".linkcours").eq(0).attr('id');

jQuery(".chrono .start").mousedown(function(){
socket.emit('start_eval',session);
if(setIntervalChrono)
clearInterval(setIntervalChrono);
var seconds = 30;
setIntervalChrono=setInterval(function () {
 
    $('.tab_intro .chrono').tzineClock1(seconds);
    seconds--;
     if(seconds==0)
       {add_c(id_exo);
	   clearInterval(setIntervalChrono);
	   }
}, 1000);
});
});

});
	function add_c(id){
	
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