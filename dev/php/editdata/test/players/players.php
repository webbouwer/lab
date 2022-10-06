<?php
    /* encryptdata */

    require_once('rwdata.php');

    $playerdata = new players;

    class players{

        private $source;
        private $filename;
        private $fields;
        private $datalist;

        public  function __construct(){

            $this->source = new rwdata;
            $this->filename = 'players.json';
            $this->datalist = array();

            // check file
            if (!(file_exists( $this->source->f . $this->filename ))) {
                $this->setDefaultData();
            }

            // check file data
            $arr = $this->source->dataFromFile( $this->filename );
            if( is_array($arr) && isset($arr['fields']) ){
                $this->datalist = $arr;
            }else{
                $this->setDefaultData();
            }

      			// insert new data
      			if( isset($_REQUEST['nm']) && isset($_REQUEST['em']) && $_REQUEST['do'] == 'save' ){
      				// check data is save
      				$newuser = array(
      					'name'=>$_REQUEST['nm'],
      					'email'=>$_REQUEST['em'],
      					'password'=>$_REQUEST['pw'],
      					'status'=>1,
      					'score'=>0
      				);
      				$this->datalist[] =  $newuser;
      				$this->source->dataToFile( $this->datalist, $this->filename );
      			}

            if( isset($_REQUEST['nr']) && isset($_REQUEST['nm']) && $_REQUEST['do'] == 'del' ){
              //if( $this->datalist[$_REQUEST['nr']]['name'] == $_REQUEST['name'] ){
                unset($arr[$_REQUEST['nr']]);
                $this->source->dataToFile( $arr, $this->filename );
              //}
            }

            // remove data
            echo json_encode($this->datalist);

        }

        private function setDefaultData(){

            $arr = [ 'fields' =>
                    [
                    'name'=>'Name',
                    'email'=>'Email',
                    'password'=> 'Password',
                    'status'=> 'Status'
                    ],
                    1 =>
                    [
                    'name'=>'guest',
                    'email'=>'',
                    'password'=> 'guest',
                    'status'=> 0
                    ],
                ];
            $this->datalist = $arr;
	        $this->source->dataToFile( $arr, $this->filename );

        }
    }


?>
