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
    case 'add':
        $dbconn->insertFormation();
        break;
    case 'fget_employee':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->getFormation($id);
        break;
    case 'fdelete':
 	$id = isset($params['id']) && $params['id'] !='' ? $params['id'] : 0;
	$dbconn->deleteFormation($id);
        break;
    case 'fedit':
	$dbconn->updateFormation();
        break;
    default:
    return;
}


class ConnectToDb {
        private $dbconn;
        protected $listOrganisme = array();
        public function connect()
	{
		$host = "127.0.0.1";
		$username = "postgres";
		$mdp = "root";
		$db = "Stage";
                $port = "5432";
                try{
                    $dbconn = pg_connect("host=$host dbname=$db user=$username
                    password=$mdp port=$port") or die('connection error');    
                } catch (Exception $ex) {

                }
                //echo "<script>console.debug( \"PHP DEBUG: $port\" );</script>";
		return $dbconn;
	}
	public function addOrganismes($lat, $lng, $name, $adr1, $adr2, $ville, $cp)
	{
            // ORGANISME
            $dbconn =  $this->connect();
            $queryoranisme = "INSERT INTO organisme (libelle_o) VALUES ('$name');";
            $resulto = pg_query($dbconn, $queryoranisme);
            if  (!$resulto) {
                 echo "<script>console.debug( \"PHP DEBUG: $resulto\" );</script>";
            }
            
            $taboid = pg_fetch_array(pg_query("SELECT currval('organisme_organisme_id_seq') as taboidr"));
            $id_orgar = $taboid["taboidr"];
            
            // ADDRESSE
            $queryadresse = "INSERT INTO adresse (rue1,rue2,lat,lng,organisme_id) VALUES ('$adr1','$adr2','$lat','$lng','$id_orgar');";
            $resulta = pg_query($dbconn, $queryadresse);
            if  (!$resulta) {
                 echo "<script>console.debug( \"PHP DEBUG: $resulta\" );</script>";
            }
            
            
            $tabaid = pg_fetch_array(pg_query("SELECT currval('adresse_adresse_id_seq') as tabaidr"));
            $id_addr = $tabaid["tabaidr"];
            
            // VILLE 
            
            $querryville = "INSERT INTO ville (libelleville,adresse_id) VALUES ('$ville','$id_addr');";
            $resultv = pg_query($dbconn, $querryville);
            if  (!$resultv) {
                 echo "<script>console.debug( \"PHP DEBUG: $resultv\" );</script>";
            }
            
            $tabvid = pg_fetch_array(pg_query("SELECT currval('ville_ville_id_seq') as tabvidr"));
            $id_ville = $tabvid["tabvidr"];
            
            
            // CP
            $querrycp = "INSERT INTO codepostal (libellecp) VALUES ('$cp');";
            $resultcp = pg_query($dbconn, $querrycp);
            if  (!$resultcp) {
                 echo "<script>console.debug( \"PHP DEBUG: $resultcp\" );</script>";
            }
            
            $tabcpid = pg_fetch_array(pg_query("SELECT currval('ville_ville_id_seq') as tabcpidr"));
            $id_cp = $tabcpid["tabcpidr"];
            
            //CP DE VILLE
            
            $querrycpdeville = "INSERT INTO cpdeville (ville_id,cp_id) VALUES ('$id_ville','$id_cp');";
            $resultcpdeville = pg_query($dbconn, $querrycpdeville);
            if  (!$resultcpdeville) {
                 echo "<script>console.debug( \"PHP DEBUG: $resultcpdeville\" );</script>";
            }
      
            
            
            pg_close($dbconn);
	}
        //public function updateOrganismes( $id, $details, $latitude, $longitude, $telephone, $keywords)
	//{
		 
		  
	//}
        
        public function get_formations() {
            $dbconn =  $this->connect();
            $sql = "SELECT f.formation_id , f.libelle_f , f.type , f.capacite , f.niv_requis , f.modalite_spe_recrutement , f.organisme_id FROM formation_organisme f";
                $queryRecords = pg_query($dbconn, $sql) or die("error to fetch employees data");
                $data = pg_fetch_all($queryRecords);
                echo json_encode($data);
          }
        public function getOrganisme() {
            
                $dbconn =  $this->connect();
		$sql = "SELECT o.organisme_id, o.libelle_o, v.libelleville, cp.libellecp FROM organisme o LEFT JOIN adresse adr ON o.organisme_id = adr.organisme_id LEFT JOIN ville v ON adr.adresse_id = v.adresse_id LEFT JOIN cpdeville cpdv ON v.ville_id = cpdv.ville_id LEFT JOIN codepostal cp ON cpdv.cp_id = cp.cp_id";
		$queryRecords = pg_query($dbconn, $sql) or die("error to fetch employees data");
                
		$listOrganisme = pg_fetch_all($queryRecords);
                echo json_encode($listOrganisme);
                pg_close($dbconn);
		//return $listOrganisme;
	}
        
        public function deleteFormation($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM formation_organisme Where formation_id='$id'";
            $queryRecords = pg_query($dbconn, $sql) or die("error to fetch employees data");
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
		pg_query($dbconn, $sql) or die("error to fetch employees data");
		
        $resp['status'] = true;
        $resp['Record'] = $data;
        echo json_encode($resp);  // send data as json format*/
		
	}
        public function getFormation($id) {
            $dbconn =  $this->connect();
            $sql = "SELECT f.formation_id , f.libelle_f , f.type , f.capacite , f.niv_requis , f.modalite_spe_recrutement , f.organisme_id FROM formation_organisme f WHERE f.formation_id = '$id'";
              $queryRecords = pg_query($dbconn, $sql) or die("error to fetch employees data");
              $data = pg_fetch_object($queryRecords);
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

              pg_insert($dbconn, 'formation_organisme' , $data) or die("error to insert employee data");


              $resp['status'] = true;
              $resp['Record'] = $data;
              echo json_encode($resp);  // send data as json format*/

          }
        
        public function deleteOrganisme($id) {
            $dbconn =  $this->connect();
            $sql = "Delete FROM organisme Where organisme_id='$id'";
            $queryRecords = pg_query($dbconn, $sql) or die("error to fetch employees data");
            if($queryRecords) {
                    echo true;
            } else {
                    echo false;
            }
            pg_close($dbconn);
        }
        
        public function getOrganimeInfoId($idorganisme)
	{
            $dbconn =  $this->connect();
            $query = "SELECT o.organisme_id, o.libelle_o, adr.adresse_id,adr.rue1,adr.rue2,adr.lat,adr.lng,v.ville_id,v.libelleville,cp.cp_id, cp.libellecp FROM organisme o LEFT JOIN adresse adr ON o.organisme_id = adr.organisme_id LEFT JOIN ville v ON adr.adresse_id = v.adresse_id LEFT JOIN cpdeville cpdv ON v.ville_id = cpdv.ville_id LEFT JOIN codepostal cp ON cpdv.cp_id = cp.cp_id WHERE o.organisme_id = '$idorganisme'";
	

            $queryRecords = pg_query($dbconn, $query) or die('query error');

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
		
               
                
                $sql ="UPDATE codepostal SET libellecp = '$cp' WHERE cp_id = '$cp_id';";
                $sql .="UPDATE ville SET libelleville = '$libelleville' WHERE ville_id = '$villeid';";
                $sql .="UPDATE organisme SET libelle_o = '$libelle_o' WHERE organisme_id ='$organisme_id';";
                $sql .="UPDATE adresse SET rue1 = '$rue1', rue2 = '$rue2', lat = '$lat' , lng = '$lng' WHERE adresse_id = '$adresse_id';";
		
		//$result = pg_update($this->conn, 'employee' , $data, array('id' => $data['id'])) or die("error to insert employee data");
                $dbconn =  $this->connect();
                
                
		pg_query($dbconn, $sql) or die("error to fetch employees data");

                pg_close($dbconn);
                $resp['status'] = true;
                $resp['Record'] = $data;
                echo json_encode($resp);  // send data as json format*/

	}
        public function getFormationsList()
	{
            $dbconn =  $this->connect();
            $query = "SELECT organisme.libelle_o , adresse.rue1 , adresse.rue2 , adresse.lat , adresse.lng, formation_organisme.libelle_f , formation_organisme.capacite, formation_organisme.niv_requis,formation_organisme.type FROM adresse , organisme , formation_organisme WHERE organisme.organisme_id = adresse.organisme_id AND organisme.organisme_id = formation_organisme.organisme_id";

            $result = pg_query($dbconn, $query) or die('query error');

            $city = array();

            $citiesArray = array();

            while ($row = pg_fetch_row($result)) {
                $city["libelle_o"] = $row[0];
                $city["rue1"] = $row[1];    
                $city["rue2"] = $row[2];
                $city["lat"] = $row[3];
                $city["lng"] = $row[4];
                $city["libelle_f"] = $row[5];
                $city["capacite"] = $row[6];
                $city["niv_requis"] = $row[7];
                $city["type"] = $row[8];
                array_push($citiesArray, $city);
            }
            pg_close($dbconn);
            
            return json_encode($citiesArray, JSON_UNESCAPED_UNICODE);
	}
}

// = new ConnectToDb();