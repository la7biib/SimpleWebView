
<?php
define( '_JEXEC', 1 );
define('JPATH_BASE', "../../" );   // should point to joomla root
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
<ul>
	<?php
	$request="SELECT id,nom from sy0uk_classe where valid=1";
	$db->setQuery( $request );
			$rows = $db->loadObjectList();
	foreach($rows as $data)
	{
	?>
      <li class='classe'><?php echo $data->nom;?>
        <ul class="categorie">
		<?php
		$req="SELECT distinct(ch.nom) as nom,ch.id as id from sy0uk_evaluation as ev inner join sy0uk_table_evaluation as ch on ch.id=ev.chapitre where ch.classe=".$data->id;
		$db->setQuery( $req);
			$rows = $db->loadObjectList();
		foreach($rows as $dd)
		{
		?>
          <li data-jstree='{"icon":"arborescence1/cat.jpg"}'><?php echo $dd->nom;?>
		 <ul>
		  <?php
		  $req4="SELECT nom,id from sy0uk_evaluation where chapitre='".$dd->id."' and valid=1";
		  $db->setQuery( $req4 );
			$rows = $db->loadObjectList();
		  foreach($rows as $ex)
		  {
		  ?>
		  <li data-jstree='{"icon":"arborescence1/ex.jpg"}'><a onclick="add_c(<?php echo $ex->id;?>)" class="linkcours" name="<?php echo $ex->nom;?>" id="<?php echo $ex->id;?>"><?php echo $ex->nom;?></a>
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
	<script>
	function instruction(instr) {
	//alert('a');
jQuery('#instruction').html("<br>"+instr);
jQuery('#instruction').css("display","block");
jQuery('#note').css("display","none");
jQuery('#retour').css("display","block");
jQuery('#divcours1').css("display","none");
}

	function add_c(id){
	//alert("jksdfhk");
	 id_cour=id;
	 var session=window.location.href.split(/#/)[1];
//alert(session); 
//jQuery("#divcours").html('');
 jQuery.ajax({
    url : "export.php?cours="+id_cour,
    type: "POST",
    success: function(data, textStatus, jqXHR)
    {
	  //document.write(data);
	  //alert(data);
	  //jQuery("#divcours").html('');
	 var cour=data.split("#**#");
	  var codehtml=cour[0];
	  var instr=cour[1];
	  jQuery('#divcours').html(codehtml);
	  jQuery("#valid_exercice").html("J’ai fini !");
	    jQuery( "#divcours *" ).mousedown(function() {
	//alert('aa');
  jQuery(this).select();
});
	  //svgCanvas.clear();
	  //updateCanvas(true);
	   //alert(id_cour);
	   //alert(instr);
	   jQuery('#mettrenote').css('display','block');
	   if(instr!=""){
	    instruction(instr);
		}
	   //afficher_cacher('note','divcours1');
	 socket.emit('cours',session+'#**#'+codehtml+'#**#'+id_cour);
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
	</script>