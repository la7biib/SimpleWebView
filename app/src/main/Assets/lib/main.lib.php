<?php
### - Functions
# function sql($request) - SQL FUNCTION
function sql($request)
 {
 global $bdd;
 $res=false;
 $bdd->exec('SET NAMES utf8');
 if(strrchr($request, 'SELECT'))
 {
 $req = $bdd->query($request);
 }
 else
 {
 $bdd->exec($request); 
 }
 if(!empty($req))
 {
 while ($data = $req->fetch())
 {
 $res[] = $data;
 }
 return $res;
 }
 else
 {
 return false;
 }
 }
 
 function pagination($limit,$nb_Resultat,$nb_affiche)
 {
 $limit2=$limit-$nb_affiche;
 $limit1=$limit+$nb_affiche;
 $nbli=6*$nb_affiche;
 
?>
<center>
<ul class="pagination">
<li class="first"><a href="index.php?rep=<?php echo $_REQUEST['rep'];?>&page=<?php echo $_REQUEST['page'];?>&limit=0"><img src="img/pagination/1.png"></a></li>
<li><a href="<?php  
if($limit2>=0)
  echo "index.php?rep=".$_REQUEST['rep']."&page=".$_REQUEST['page']."&limit=".$limit2;
  
?>
"><img src="img/pagination/prec.png"></a></li>

<?php
if($nb_Resultat>=$nbli)
$nb_Resultat1=$nbli;
else 
$nb_Resultat1=$nb_Resultat;
if($limit<$nbli)
for($i=1;$i<$nb_Resultat1/$nb_affiche+1;$i++)
{
$link=($i-1)*$nb_affiche;
echo "<li";
if($i==$limit/$nb_affiche+1)
echo ' class="select"';
echo "><a href='index.php?rep=".$_REQUEST['rep']."&page=".$_REQUEST['page']."&limit=$link'>".round($i)."</a></li>";
}
else if($limit<=$nb_Resultat-$nbli)
{$nb_Resultat1=($limit/$nb_affiche)+6;
echo '<li><a>...</a></li>';
for($i=$limit/$nb_affiche;$i<$nb_Resultat1;$i++)
{
$link=($i-1)*$nb_affiche;
echo "<li";
if($i==$limit/$nb_affiche+1)
echo ' class="select"';
echo "><a href='index.php?rep=".$_REQUEST['rep']."&page=".$_REQUEST['page']."&limit=$link'>".round($i)."</a></li>";
}
}
else
{

$nb_Resultat1=($limit)/$nb_affiche;
echo '<li><a>...</a></li>';
for($i=$nb_Resultat1;$i<$nb_Resultat/$nb_affiche+1;$i++)
{$link=($i-1)*$nb_affiche;
echo "<li";
if($i==$limit/$nb_affiche+1)
echo ' class="select"';
echo "><a href='index.php?rep=".$_REQUEST['rep']."&page=".$_REQUEST['page']."&limit=$link'>".round($i)."</a></li>";
}
}
if($nb_Resultat>=$nbli&&$limit<=$nb_Resultat-$nbli)
{$nbres=round(($nb_Resultat-$nb_affiche)/$nb_affiche+1);
$ll=$nb_Resultat-$nb_affiche;
echo "<li><a>...</a></li><li><a href='index.php?rep=".$_REQUEST['rep']."&page=".$_REQUEST['page']."&limit=$ll'>".$nbres ."</a></li>";
}
?>


<li><a href="<?php
  //echo $limit1."/".$nb_Resultat;
  if($limit1<=$nb_Resultat)
echo "index.php?rep=".$_REQUEST['rep']."&page=".$_REQUEST['page']."&limit=".$limit1;
  
  ?>"><img src="img/pagination/suiv.png"></a></li>
<li class="last"><a  href="index.php?rep=<?php echo $_REQUEST['rep'];?>&page=<?php echo $_REQUEST['page'];?>&limit=<?php  echo $nb_Resultat-3;?>"><img src="img/pagination/2.png"></a></li>

<ul></center>

<?php
}
 function pays($nom)
 {
 echo "<option class='first'  value='' default>Sélectionner votre pays</option>";
 $request="SELECT * FROM `pays` ORDER BY `id_pays`";
foreach(sql($request) as $data)
{
echo "<option value='".$data['code_pays']."'";
if($data['code_pays']==$nom) echo " selected ";
echo ">".utf8_encode($data['fr'])."</option>";
} 
 }
 
 function getContenu($lang)
 {$user="SELECT * FROM `contenu_fr` WHERE id=$lang";
if(sql($user))
{
return sql($user);
 
 }
 }
 function lang($id)
{

echo "<select name='lang'  class='validate[required]'><option value=''></option>";

$request="SELECT * FROM  `lang` ORDER BY id";
foreach(sql($request) as $data)
{
echo "<option value='".$data['id']."'";
if($data['id']==$id) echo "selected";
echo ">".$data['nom']."</option>";
}

echo "</select>";
}
 function getAccueil($lang)
 {
 $user="SELECT * FROM `accueil_fr` WHERE id=$lang";
if(sql($user))
{
return sql($user);

}
 }
  function incrementeBan($id)
 {
 $user="update bannieres set affichage=affichage+1 WHERE id=$id";
if(sql($user))
{
sql($user);

}
 }
 
?>