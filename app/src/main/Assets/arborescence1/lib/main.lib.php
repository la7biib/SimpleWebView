<?php
### - Functions
# function sql($request) - SQL FUNCTION
function sql($request)
 {
 global $bdd;
 $res=false;
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
?>