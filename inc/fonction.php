<?php

class ConnectToDb {
        private $dbconn;
        public function connect()
	{
		$host = "172.19.40.43";
		$username = "emaprun";
		$mdp = "Stage987456321";
		$db = "Stage";
                $port = "5432";
                try{
                    $dbconn = pg_connect("host=$host dbname=$db user=$username
                    password=$mdp port=$port") or die('connection error');    
                } catch (Exception $ex) {

                }

		return $dbconn;
	}
	public function addOrganismes($lat, $lng, $name, $adr1, $adr2, $ville, $cp)
	{
            $dbconn =  $this->connect();
            $query = "INSERT INTO organisme (libelle_o) VALUES ('$name');";
            $result = pg_query($dbconn, $query);
            if  (!$result) {
                 echo "<script>console.debug( \"PHP DEBUG: $result\" );</script>";
            }
            $last_id_query = pg_query("SELECT currval('customer_id_seq')");

            $last_id_results = pg_fetch_assoc($last_id_query);

            print_r($last_id_results);
            pg_close($dbconn);
            addAdresse();
	}
        public function addAdresse($lat, $lng,$adr1, $adr2, $ville, $cp){
            
        }
}

$dbconn = new ConnectToDb();