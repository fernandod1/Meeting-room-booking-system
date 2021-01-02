<?php

class Rooms{

    private $dbFile;
    private $rooms;
    private $roomsFeatures;
  
    function Rooms($roomsFeatures){
        
        $this->dbFile = '';
        $this->rooms = '';
        $this->roomsFeatures = $roomsFeatures;                
    }

    public function readRoomsDatabase($datePicked)
    {
        $formatDate = explode("/", $datePicked);
        $this->dbFile = $formatDate[2]."-".$formatDate[1]."-".$formatDate[0]."_rooms_db.txt";
        if(!file_exists($this->dbFile)){ 
            $fp = fopen($this->dbFile, "w") or die("Unable to open file for writing!");
            foreach ($this->roomsFeatures as $roomId => $roomCapability) {
                fwrite($fp, $roomId.','.$roomCapability."\n");
            }
            fclose($fp);
        }
        clearstatcache();
        $fp = fopen($this->dbFile, 'r') or die("Unable to open file for reading!");
        $this->rooms = explode("\n", fread($fp, filesize($this->dbFile)));
        fclose($fp);
    }

    public function writeRoomsDatabase($startTime,$endTime,$roomId)
    {
        $lines = file($this->dbFile); 
        $new = '';        
        if (is_array($lines)) {
            foreach($lines as $line) {
                $data1room = explode(",", $line);
                $line = str_replace("\n","",$line);
                if($data1room[0]==$roomId){
                    $new .= $line . ',' . $startTime . ',' . $endTime . "\n";
                } else{
                    $new .= $line . "\n";
                }
            } 
        }        
        file_put_contents($this->dbFile, $new);
    }

    public function printRoomsDatabase($datePicked)
    {
        $this->readRoomsDatabase($datePicked);
        foreach ($this->rooms as $room) {
            if(!empty($room)){
                $data1room = explode(",", $room);
                echo '<span class="badge bg-primary">Room ID: '.$data1room[0].'</span> ';
                echo '<span class="badge bg-secondary">Capacity: '.$data1room[1].'</span> ';
                for ($i=2;$i<sizeof($data1room);$i++){
                    if ($i%2==0)
                        echo '<span class="badge rounded-pill bg-danger">'.$data1room[$i].'-'.$data1room[$i+1].'</span>';
                }
                echo "<br>";
            }
        }
    }

    public function getOptimizedCapacityRoom($rooms, $numCapacity)
    {
        $bestTempRoomId=0;
        $bestTempCapacity=999;
        foreach ($rooms as $room) {
            if(!empty($room)){
                $data1room = explode(",", $room);
                if($this->checkRoomCapacity($room, $numCapacity)==true && $bestTempCapacity>$data1room[1]){
                    $bestTempRoomId=$data1room[0];
                    $bestTempCapacity=$data1room[1];
                }
            }
        }
        return $bestTempRoomId;
    }

    private function checkRoomCapacity($room, $numCapacity)
    {
        $okCapacity=false; 
            $data1room = explode(",", $room);
            if($data1room[1]>=$numCapacity){
                $okCapacity=true;
            }
        return $okCapacity;
    }

    private function compareHours($val, $min, $max) {  
            return ($val > $min && $val < $max);
    }

    public function getAvailableRooms($startTime,$endTime){
        $discard = false;
        $roomsOk = array();
        foreach ($this->rooms as $room) {
            $data1room = explode(",", $room);
            for ($i=0;$i<((sizeof($data1room)-2)/2);$i++)
            {
                if($this->compareHours(strtotime($startTime), strtotime($data1room[2+(2*$i)]), strtotime($data1room[3+(2*$i)]))
                || $this->compareHours(strtotime($endTime), strtotime($data1room[2+(2*$i)]), strtotime($data1room[3+(2*$i)])+1)){
                    $discard=true;                    
                }
            }
            if($discard==false)
                array_push($roomsOk, $room);
            else if( ((sizeof($data1room))-2)/2==0){ // all time frames availables
                array_push($roomsOk, $room);
            }
            $discard = false;
        }
            return $roomsOk;

    }


}


?>