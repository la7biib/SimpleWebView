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
?>
  <!-- 3 setup a container element -->

    <!-- in this example the tree is populated from inline HTML -->

	    <ul  id="navigation">
	<?php
	$request="SELECT id,nom from sy0uk_classe where valid=1";
	$db->setQuery( $request );
			$rows = $db->loadObjectList();
	foreach($rows as $data)
	{
	?>
      <li class="toggleSubMenu"><span><?php echo $data->nom;?></span>
        <ul class="subMenu">
		<?php
		$req="SELECT id,nom from sy0uk_categorie where classe='".$data->id."' and parent=0 and valid=1";
		$db->setQuery( $req);
			$rows = $db->loadObjectList();
		foreach($rows as $dd)
		{
		?>
          <li class="toggleSubMenu"><span><?php echo $dd->nom;?></span>
		  
		  <ul class="subMenu">
		  <?php
		  $req3="SELECT id,nom from sy0uk_chapitre where categorie='".$dd->id."' and valid=1";
		  $db->setQuery( $req3 );
			$rows = $db->loadObjectList();
		  foreach($rows as $f)
		  {
		  ?>
		  <li class="toggleSubMenu chapitre"><span><?php echo $f->nom;?></span>
		  <ul class="subMenu">
		   <?php
		  $req4="SELECT nom,id from sy0uk_cours where active=1 AND chapitre='".$f->id."' and valid=1 AND type_cours=3";
		  $db->setQuery( $req4 );
			$rows = $db->loadObjectList();
		  foreach($rows as $ex)
		  {
		  ?>
		  <li><a onclick="add_c(<?php echo $ex->id;?>)" class="linkcours" name="<?php echo $ex->nom;?>" id="<?php echo $ex->id;?>"><?php echo $ex->nom;?></a>
		  </li>
		  <?php
		  }
		  
		  $req4="SELECT nom,id from sy0uk_cours where active=1 AND chapitre='".$f->id."' AND type_cours<>3 and valid=1 order by niveau limit 0,5";
		  $db->setQuery( $req4 );
			$rows = $db->loadObjectList();
		  foreach($rows as $ex)
		  {
		  ?>
		  <li><a onclick="add_c(<?php echo $ex->id;?>)" class="linkcours" name="<?php echo $ex->nom;?>" id="<?php echo $ex->id;?>"><?php echo $ex->nom;?></a>
		  </li>
		  <?php
		  }
		  ?>
		  </ul>
		  </li>
		  <?php
		  }
		  ?>
		  
		  <?php
		  $req1="SELECT id,nom from sy0uk_categorie where parent='".$dd->id."' and valid=1";
		  $db->setQuery( $req1 );
			$rows = $db->loadObjectList();
		  foreach($rows as $d)
		  {
		  ?>
		  <li class="toggleSubMenu"><span><?php echo $d->nom;?></span>
		  <ul class="subMenu">
		  <?php
		  $req2="SELECT id,nom from sy0uk_chapitre where categorie='".$d->id."' and valid=1";
		  $db->setQuery( $req2 );
			$rows = $db->loadObjectList();
		  foreach($rows as $ch)
		  {
		  ?>
		  <li class="toggleSubMenu chapitre"><span><?php echo $ch->nom;?></span>
		  <ul class="subMenu">
		    <?php
		  $req4="SELECT nom,id from sy0uk_cours where active=1 AND chapitre='".$f->id."' and valid=1 AND type_cours=3";
		  $db->setQuery( $req4 );
			$rows = $db->loadObjectList();
		  foreach($rows as $ex)
		  {
		  ?>
		  <li><a onclick="add_c(<?php echo $ex->id;?>)" class="linkcours" name="<?php echo $ex->nom;?>" id="<?php echo $ex->id;?>"><?php echo $ex->nom;?></a>
		  </li>
		  <?php
		  }
		  
		  $req4="SELECT nom,id from sy0uk_cours where  active=1 AND chapitre='".$ch->id."' and valid=1 AND type_cours<>3 order by niveau limit 0,5";
		  $db->setQuery( $req4 );
			$rows = $db->loadObjectList();
		  foreach($rows as $ex)
		  {
		  ?>
 <li><a onclick="add_c(<?php echo $ex->id;?>)" class="linkcours" name="<?php echo $ex->nom;?>" id="<?php echo $ex->id;?>"><?php echo $ex->nom;?></a>
		  
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
		  </li>
		  <?php
		  }
		  ?>
		  </ul>
		  
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