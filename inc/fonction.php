<?php



$params = $_REQUEST;
$action = isset($params['action']) && $params['action'] !='' ? $params['action'] : 'edit';
$dbconn = new ConnectToDb();
 
switch($action) {
    case 'olist':
        $dbconn->getOrganisme();
        break;
    case 'oget_organisme':
        $id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
        $dbconn->getOrganimeInfoId($id);
        break;
    case 'oedit':
	$dbconn->updateOrganisme();
        break;
    case 'odelete':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->deleteOrganisme($id);
        break;
    case 'flist':
        $dbconn->get_formations();
        break;
    case 'flisttemp':
        $dbconn->get_formationstemp();
        break;
    case 'olisttemp':
        $dbconn->get_organismetemp();
        break;
    case 'clist':
        $dbconn->get_comptelist();
        break;
    case 'add':
        $dbconn->insertFormation();
        break;
    case 'fget_employee':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->getFormation($id);
        break;
    case 'get_compte':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->getcompte($id);
        break;
    case 'fdelete':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->deleteFormation($id);
        break;
    case 'fdeletetemp':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->deleteFormationTemp($id);
        break;
    case 'odeletetemp':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->deleteOrganismeTemp($id);
        break;
    case 'oktemp':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->OkFormationTemp($id);
        break;
    case 'oktempo':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->OkOrganismeTemp($id);
        break;
    case 'cdelete':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->deleteCompte($id);
        break;
    case 'fedit':
	$dbconn->updateFormation();
        break;
    case 'cedit':
	$dbconn->updateCompte();
        break;
    case 'deroullist':
	$dbconn->getDeroulList();
        break;
    case 'deroullisttype':
	$dbconn->getDeroulListType();
        break;
     case 'deroullistville':
	$dbconn->getDeroulListVille();
        break;
    case 'recherche':
        $search = isset($params['q']) && $params['q'] !='' ? $params['q'] : 0;
	$dbconn->getSearchResult($search);
        break;
    default:
    return;
}


class ConnectToDb {
        private $dbconn;
        protected $listOrganisme = array();
        public function connect()
	{
		$host = "172.19.40.43";
		$username = "fabrice";
		$mdp = "fabrice";
                $db = "THOMAS";
                $port = "5432";
                try{
                    $dbconn = pg_connect("host=$host dbname=$db user=$username
                    password=$mdp port=$port") or die('Impossible de vous connectez à la base de donnée');    
                } catch (Exception $ex) {

                }
                //echo "<script>console.debug( \"PHP DEBUG: $port\" );</script>";
		return $dbconn;
	}
        
	public function addOrganismes($lat, $lng, $name, $adr1, $adr2, $cpdeville , $telephone, $email , $intituleadresse)
	{
            // ORGANISME
            $dbconn =  $this->connect();
            $query = 'INSERT INTO temp_organismes (name,lat,lng,rue1,rue2,cpdeville,email,telephone,intituleadresse) VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9)';
            
            $tempinsert = pg_prepare($dbconn, "temp_orga",$query);  
            $tempinsert = pg_execute($dbconn, "temp_orga", array($name,$lat,$lng,$adr1,$adr2,$cpdeville,$email,$telephone,$intituleadresse)) or die("Impossible d'inserer la formation temporaire (en attente de vérification/confirmation)");
            
            //echo $lat.$lng.$name.$adr1.$adr2.$cpdeville.$telephone.$email.$intituleadresse;
            
            if  (!$tempinsert) {
                 echo "<script>console.debug( \"PHP DEBUG: $tempinsert\" );</script>";
            }
            
            
            pg_close($dbconn);
	}
        //public function updateOrganismes( $id, $details, $latitude, $longitude, $telephone, $keywords)
	//{
		 
		  
	//}
        
        public function get_formations() {
            $dbconn =  $this->connect();
            $sql = "SELECT f.formation_id , f.libelle_f , f.type , f.capacite , f.niv_requis , f.modalite_spe_recrutement , f.organisme_id , organisme.libelle_o FROM formation_organisme f LEFT JOIN organisme ON organisme.organisme_id = f.organisme_id";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossible d'avoir la liste des formations");
            $data = pg_fetch_all($queryRecords);
            echo json_encode($data);
        }
        public function get_formationstemp() {
            $dbconn =  $this->connect();
            $sql = "SELECT f.temp_id , f.libelle_f , f.type , f.capacite , f.niv_requis , f.modalite_spe_recrutement , f.organisme_id , o.libelle_o , libelleville , cp_id FROM temp_formations f LEFT JOIN organisme o ON o.organisme_id = f.organisme_id LEFT JOIN adresse a ON a.organisme_id = o.organisme_id LEFT JOIN cpdeville cp ON cp.cpdeville_id = a.cpdeville LEFT JOIN ville v ON v.ville_id = cp.ville_id";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossible d'avoir la liste des formations temporaires");
            $data = pg_fetch_all($queryRecords);
            echo json_encode($data);
        }
        public function get_organismetemp() {
            $dbconn =  $this->connect();
            $sql = "SELECT temp_id , name , rue1 , rue2 , libelleville , cp_id , email , telephone , intituleadresse FROM temp_organismes f LEFT JOIN cpdeville cp ON cp.cpdeville_id = f.cpdeville LEFT JOIN ville v ON v.ville_id = cp.ville_id";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossible d'avoir la liste des formations temporaires");
            $data = pg_fetch_all($queryRecords);
            echo json_encode($data);
        }
         public function get_comptelist() {
            $dbconn =  $this->connect();
            $sql = "SELECT compte_id , email , nom , activate_status , droittype FROM compte";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossible d'avoir la liste des formations");
            $data = pg_fetch_all($queryRecords);
            echo json_encode($data);
          }
        public function getOrganisme() {
            
                $dbconn =  $this->connect();
		$sql = 'SELECT * FROM public."FgetOrganisme"';
		$queryRecords = pg_query($dbconn, $sql) or die("Impossible d'avoir la liste des organismes");
                
		$listOrganisme = pg_fetch_all($queryRecords);
                echo json_encode($listOrganisme);
                pg_close($dbconn);
		//return $listOrganisme;
	}
        
        public function deleteFormation($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM formation_organisme Where formation_id='$id'";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossibles de supprimé la formation");
            if($queryRecords) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        public function deleteFormationTemp($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM temp_formations Where temp_id='$id'";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossibles de supprimé la formation temporaire");
            if($queryRecords) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        public function deleteOrganismeTemp($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM temp_organismes Where temp_id='$id'";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossibles de supprimé l'organisme temporaire");
            if($queryRecords) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        public function OkFormationTemp($id) {
            $dbconn =  $this->connect();
            $sql = "UPDATE temp_formations SET temp_id='$id' WHERE temp_id='$id'";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossibles de confirmer la formation temporaire");
            if($queryRecords) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        public function OkOrganismeTemp($id) {
            $dbconn =  $this->connect();
            $sql = "UPDATE temp_organismes SET temp_id='$id' WHERE temp_id='$id'";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossibles de confirmer l'organisation temporaire");
            if($queryRecords) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        public function deleteCompte($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM compte Where compte_id='$id'";
            $queryRecords = pg_query($dbconn, $sql) or die("Impossibles de supprimé le compte");
            if($queryRecords) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        public function updateFormation() {
            $dbconn =  $this->connect();
		$data = $resp = array();
		$resp['status'] = false;
                
		$libelle_f = $data['libelle_f'] = $_POST["libelle_f"];
		$type = $data['type'] = $_POST["type"];
		$capacite = $data['capacite'] = $_POST["capacite"];
                $niv_requis = $data['niv_requis'] = $_POST["niv_requis"];
                $modalite_spe_recrutement = $data['modalite_spe_recrutement'] = $_POST["modalite_spe_recrutement"];
                $organisme_id = $data['organisme_id'] = $_POST["organisme_id"];
                
		$forma_id = $data['formation_id'] = $_POST["formation_id"];
		
                $sql = "UPDATE formation_organisme SET libelle_f = '$libelle_f', type = '$type' , capacite = '$capacite' , niv_requis ='$niv_requis' , modalite_spe_recrutement = '$modalite_spe_recrutement' , organisme_id = '$organisme_id' WHERE formation_id = '$forma_id'";
		pg_query($dbconn, $sql) or die("Impossible de mettre à jour la formation");
        $resp['status'] = true;
        $resp['Record'] = $data;
        echo json_encode($resp);  // send data as json format*/
		
	}
        public function updateCompte() {
            $dbconn =  $this->connect();
		$data = $resp = array();
		$resp['status'] = false;
                
		$email = $data['email'] = $_POST["emailcompte"];
		$nom = $data['nom'] = $_POST["nom"];
		$capacite = $data['capacite'] = $_POST["capacite"];
                $niv_requis = $data['niv_requis'] = $_POST["niv_requis"];
                
		$compte_id = $data['compte_id'] = $_POST["compte_id"];
		
                $sql = "UPDATE compte SET email = '$email', nom = '$nom' , activate_status = '$capacite' , droittype ='$niv_requis' WHERE compte_id = '$compte_id'";
		pg_query($dbconn, $sql) or die("Impossible de mettre à jour la formation");
        $resp['status'] = true;
        $resp['Record'] = $data;
        echo json_encode($resp);  // send data as json format*/
		
	}
        public function getFormation($id) {
            $dbconn =  $this->connect();
            $sql = "SELECT f.formation_id , f.libelle_f , f.type , f.capacite , f.niv_requis , f.modalite_spe_recrutement , f.organisme_id FROM formation_organisme f WHERE f.formation_id = $1";
            $result = pg_prepare($dbconn, "get_formation",$sql);  
            $result = pg_execute($dbconn, "get_formation", array($id)) or die("Impossible d'avoir les informations de la formation");
            $data = pg_fetch_object($result);
            echo json_encode($data);
        }
        public function getcompte($id) {
            $dbconn =  $this->connect();
            $sql = "SELECT compte_id , email , nom , activate_status , droittype FROM compte WHERE compte_id = $1";
            $result = pg_prepare($dbconn, "get_compte",$sql);  
            $result = pg_execute($dbconn, "get_compte", array($id)) or die("Impossible d'avoir les informations du compte");
            $data = pg_fetch_object($result);
            echo json_encode($data);
        }
        
        
       public function insertFormation() {
           $dbconn =  $this->connect();
              $data = $resp = array();
              $resp['status'] = false;
              
              
              $data['libelle_f'] = filter_input(INPUT_POST, 'libelle_f');
              $data['type'] = filter_input(INPUT_POST, 'type');
              $data['capacite'] = filter_input(INPUT_POST, 'capacite');
              $data['niv_requis'] = filter_input(INPUT_POST, 'niv_requis');
              $data['modalite_spe_recrutement'] = filter_input(INPUT_POST, 'modalite_spe_recrutement');
              $data['organisme_id'] = filter_input(INPUT_POST, 'organisme_id');

              pg_insert($dbconn, 'temp_formations' , $data) or die("Impossible d'inserer une nouvelle formation");


              $resp['status'] = true;
              $resp['Record'] = $data;
              echo json_encode($resp);  // send data as json format*/

          }
        
        public function deleteOrganisme($id) {
            $dbconn =  $this->connect();
            // Sup tout les formations liés
            $deleteformation = "DELETE FROM formation_organisme WHERE organisme_id = '$id'";
            pg_query($dbconn, $deleteformation) or die('Impossible effacé forma ');  
            // Sup tout les emails liés
            $deleteemail = "DELETE FROM mail WHERE organisme_id = '$id'";
            pg_query($dbconn, $deleteemail) or die('Impossible effacé email '); 
            
            // Recup donnée des id à sup
            $selectid = "SELECT o.organisme_id, adr.adresse_id FROM organisme o LEFT JOIN adresse adr ON o.organisme_id = adr.organisme_id WHERE o.organisme_id = '$id'";
            $queryRecords = pg_query($dbconn, $selectid) or die('query error');          
            $donneeid = array();
            while ($row = pg_fetch_row($queryRecords)) {
                $donneeid["adresse_id"] = $row[1];
            }
            
             // Sup adresse
            $adresse_id = $donneeid["adresse_id"];
            $deleteadresse= "DELETE FROM adresse WHERE adresse_id = '$adresse_id'";
            pg_query($dbconn, $deleteadresse) or die('Impossible effacé adresse '); 
            
            $deletetel = "DELETE FROM adresse_telephone WHERE adresse_id = '$adresse_id'";
            pg_query($dbconn, $deletetel) or die('Impossible effacé tel ');  
            
            // Sup Orga
            
            $orga_id = $donneeid["organisme_id"];
            $deleteorga = "DELETE FROM organisme WHERE organisme_id = '$orga_id'";
            pg_query($dbconn, $deleteorga) or die('Impossible effacé orga '); 
           
            
            

            pg_close($dbconn);
        }
        
        public function getOrganimeInfoId($idorganisme)
	{
            $dbconn =  $this->connect();
            $query = "SELECT o.organisme_id, o.libelle_o, adr.adresse_id,adr.rue1,adr.rue2,adr.lat,adr.lng,v.ville_id,v.libelleville,cp.cp_id, cp.libellecp, em.mail,em.mail_id , tel.telephone,tel.telephone_id FROM organisme o RIGHT JOIN mail em ON o.organisme_id = em.organisme_id RIGHT JOIN telephone tel ON o.organisme_id = tel.organisme_id LEFT JOIN adresse adr ON o.organisme_id = adr.organisme_id LEFT JOIN ville v ON adr.adresse_id = v.adresse_id LEFT JOIN cpdeville cpdv ON v.ville_id = cpdv.ville_id LEFT JOIN codepostal cp ON cpdv.cp_id = cp.cp_id WHERE o.organisme_id = '$idorganisme'";

            $queryRecords = pg_query($dbconn, $query) or die("Impossible d'avoir les informations de cette organisme");

            $listOrganisme = pg_fetch_all($queryRecords);
            pg_close($dbconn);
            echo json_encode($listOrganisme);
	}
	public function updateOrganisme() {
            
                
		$data = $resp = array();
		$resp['status'] = false;
                
                // Les id's
                $organisme_id = $data['organisme_id'] = filter_input(INPUT_POST, 'organisme_id');
                $cp_id = $data['cp_id'] = filter_input(INPUT_POST, 'cp_id');
                $adresse_id = $data['adresse_id'] = filter_input(INPUT_POST, 'adresse_id');
                $villeid = $data['ville_id'] = filter_input(INPUT_POST, 'ville_id');
                
                
                
                
               
                
                
                // données
		$libelle_o = $data['libelle_o'] = filter_input(INPUT_POST, 'organisme_libelle');
		$libelleville = $data['libelleville'] = filter_input(INPUT_POST, 'o_libelleville');
		$cp = $data["libellecp"] = filter_input(INPUT_POST, 'o_libellecp');
                
                $rue1 = $data['rue1'] = filter_input(INPUT_POST, 'o_rue1');
                $rue2 = $data['rue2'] = filter_input(INPUT_POST, 'o_rue2');
                $lat = $data['lat'] = filter_input(INPUT_POST, 'o_lat');
                $lng = $data['lng'] = filter_input(INPUT_POST, 'o_lng');
                
                $tel = $data['telephone'] = filter_input(INPUT_POST, 'o_tel');
                $email = $data['mail'] = filter_input(INPUT_POST, 'o_email');
		
               
                
                $sql ="UPDATE codepostal SET libellecp = '$cp' WHERE cp_id = '$cp_id';";
                $sql .="UPDATE ville SET libelleville = '$libelleville' WHERE ville_id = '$villeid';";
                $sql .="UPDATE organisme SET libelle_o = '$libelle_o' WHERE organisme_id ='$organisme_id';";
                $sql .="UPDATE adresse SET rue1 = '$rue1', rue2 = '$rue2', lat = '$lat' , lng = '$lng' WHERE adresse_id = '$adresse_id';";
                $sql .="UPDATE mail SET mail = '$email' WHERE organisme_id = '$organisme_id';";
                $sql .="UPDATE telephone SET telephone = '$tel' WHERE organisme_id = '$organisme_id';";
		
		//$result = pg_update($this->conn, 'employee' , $data, array('id' => $data['id'])) or die("error to insert employee data");
                $dbconn =  $this->connect();
                
                
		pg_query($dbconn, $sql) or die("Impossible d'effecuté la mise à jour de l'organisme");

                pg_close($dbconn);
                $resp['status'] = true;
                $resp['Record'] = $data;
                echo json_encode($resp);  // send data as json format*/

	}
        public function getFormationsList()
	{
            $dbconn =  $this->connect();
            $query = "SELECT o.organisme_id, o.libelle_o, adr.rue1 , adr.rue2 , adr.lat , adr.lng, fo.libelle_f , fo.capacite, fo.niv_requis,fo.type,fo.modalite_spe_recrutement , cp.cp_id , v.libelleville FROM formation_organisme fo RIGHT JOIN organisme o ON o.organisme_id = fo.organisme_id LEFT JOIN adresse adr ON o.organisme_id = adr.organisme_id LEFT JOIN cpdeville cp ON cp.cpdeville_id = adr.cpdeville LEFT JOIN ville v ON v.ville_id = cp.ville_id";

            $result = pg_query($dbconn, $query) or die("Impossible d'avoir la liste des formations");

            $city = array();

            $citiesArray = array();

            while ($row = pg_fetch_row($result)) {
                $city["libelle_o"] = $row[1];
                $city["rue1"] = $row[2];
                $city["rue2"] = $row[3];
                $city["lat"] = $row[4];
                $city["lng"] = $row[5];
                $city["libelle_f"] = $row[6];
                $city["capacite"] = $row[7];
                $city["niv_requis"] = $row[8];
                $city["type"] = $row[9];
                $city["modalite_spe_recrutement"] = $row[10];
                $city["libellecp"] = $row[11];               
                $city["libelleville"] = $row[12];
                
                
                    

                
                
                
                
                
                array_push($citiesArray, $city);
            }
            pg_close($dbconn);
            
            return json_encode($citiesArray, JSON_UNESCAPED_UNICODE);
	}
        public function getDeroulList(){          
            if(isset($_GET['go'])) {  
               
                $dbconn =  $this->connect();
                $queryoranisme = "SELECT * FROM organisme ORDER BY libelle_o ASC";
                
                
                $queryRecords = pg_query($dbconn, $queryoranisme) or die("error to fetch employees data");
                $data = pg_fetch_all($queryRecords);
                echo json_encode($data);

            }
        }
        public function getDeroulListVille(){          
            if(isset($_GET['villes'])) {   // requête qui récupère les localités un
               
                $dbconn =  $this->connect();
                $queryoranisme = "SELECT c.cpdeville_id , c.cp_id , v.libelleville FROM cpdeville c LEFT JOIN ville v ON v.ville_id = c.ville_id ORDER BY v.libelleville ASC";
                
                
                $queryRecords = pg_query($dbconn, $queryoranisme) or die("Impossible d'avoir la liste des villes");
                $data = pg_fetch_all($queryRecords);
                echo json_encode($data);

            }
        }
        public function getDeroulListType(){          
            if(isset($_GET['types'])) {   // requête qui récupère les localités un
               
                $dbconn =  $this->connect();
                $queryoranisme = "SELECT DISTINCT type FROM formation_organisme ORDER BY type ASC";
                
                
                $queryRecords = pg_query($dbconn, $queryoranisme) or die("Impossible d'avoir la liste des types formations");
                $data = pg_fetch_all($queryRecords);
                echo json_encode($data);

            }
        }
        public function getSearchResult($search){  
            
            function searchInit($text)	//search initial text in titles
            {
                    //$reg = '/'.$_GET['q'].'/';	//initial case insensitive searching
                     //$reg = '/''/';	//initial case insensitive searching
                    return preg_match('/'.$_GET['q'].'/', $text['title']);
            }
            if(!isset($_GET['q']) or empty($_GET['q']))
            {
                die( json_encode(array('ok'=>0, 'errmsg'=>'Erreur lors de la recherche !') ) );
            } else {
                $searcharray = array();
                $AllSearch = array();
                $dbconn =  $this->connect();
                $queryoranisme = "SELECT lat , lng , libelle_f ,libelleville libelleville FROM formation_organisme fo RIGHT JOIN organisme o ON o.organisme_id = fo.organisme_id LEFT JOIN adresse addr ON addr.organisme_id = o.organisme_id LEFT JOIN ville v ON v.adresse_id = addr.adresse_id";         
                $queryRecords = pg_query($dbconn, $queryoranisme) or die("Impossible d'effectué la recherche");
                //$data = pg_fetch_all($queryRecords);
                while ($row = pg_fetch_row($queryRecords)) {
                    $searcharray["loc"] = [$row[0],$row[1]];                

                    $searcharray["title"] = $row[2]." <b>".$row[3]."</b>"; 
                    //echo $searcharray["title"];
                    array_push($AllSearch, $searcharray);
                }
                $fdata = array_filter($AllSearch, 'searchInit');	//filter data
                $fdata = array_values($fdata);	//reset $fdata indexs
                echo json_encode($fdata);
            }
        }
}

// = new ConnectToDb();