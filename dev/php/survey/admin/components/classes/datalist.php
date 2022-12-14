<?php require_once('protected.php');
    /* encryptdata */

    require_once('rwdata.php');

    $activeData = new dataList;

    class dataList{

        private $source;
        private $filename;
        private $fields;
        private $datalist;

        public  function __construct(){

            $this->source = new rwdata;
            $this->filename = 'datalist.json';
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

            if( isset($_REQUEST['action']) ){

              // save data
              if( isset($_REQUEST['data']) && $_REQUEST['action'] == 'save' ){

                  // replace field value
                  if( isset($_REQUEST['data']['nr']) && isset($_REQUEST['data']['field']) && isset($_REQUEST['data']['content']) ){
                    $arr[ $_REQUEST['data']['nr'] ][ $_REQUEST['data']['field'] ] = $_REQUEST['data']['content'];
          	        $this->source->dataToFile( $arr, $this->filename );
                  }

              }
              // copy row data
              if( isset($_REQUEST['data']) && $_REQUEST['action'] == 'copy' ){

                  // replace field value
                  if( isset($_REQUEST['data']['nr']) ){
                    $copy = $arr[ $_REQUEST['data']['nr'] ];
                    $copy['id'] = $copy['id'].'-'. $_REQUEST['data']['nr'];
                    $copy['title'] = $copy['title'].'-'. $_REQUEST['data']['nr'];
                    $copy['desc'] = 'copy-'. $_REQUEST['data']['nr'] .'- '. $copy['desc'];
                    $arr[] = $copy;
          	        $this->source->dataToFile( $arr, $this->filename );
                  }

              }
              // delete row data
              if( isset($_REQUEST['data']) && $_REQUEST['action'] == 'delete' ){

                  // replace field value
                  if( isset($_REQUEST['data']['nr']) ){
                    unset( $arr[ $_REQUEST['data']['nr'] ] );
          	        $this->source->dataToFile( $arr, $this->filename );
                  }
              }

              // add new
              if( $_REQUEST['action'] == 'new' ){

                  // add new row with fields
                  $this->defineFields();
                  $new = $this->fields[1];
                  $arr[] = $new;
          	      $this->source->dataToFile( $arr, $this->filename );

              }
           }
          //echo json_encode($this->datalist);
          print_r(json_encode($arr));

        }

        private function defineFields(){

          $json = [

          			"0"=> [
          				"question"=> "Ik voel mij gehoord in mijn ervaring van discriminatie.",
                  "type"=> "value",
          				"required"=> 1,
          				"tips"=> "Waardering van 1 tot 5",
          				"answers"=> [
          					"0"=> "1",
          					"1"=> "2",
          					"2"=> "3",
          					"3"=> "4",
          					"4"=> "5"
          				]
          			],
          			"1"=> [
          				"question"=> "Ik kwam makkelijk in contact met Stichting iDb.",
                  "type"=> "value",
          				"required"=> 1,
          				"tips"=> "Waardering van 1 tot 5",
          				"answers"=> [
          					"0"=> "1",
          					"1"=> "2",
          					"2"=> "3",
          					"3"=> "4",
          					"4"=> "5"
          				]
          			],
          			"2"=> [
          				"question"=> "Ik ben effici??nt geholpen en/of doorverwezen.",
                  "type"=> "value",
          				"required"=> 1,
          				"tips"=> "Waardering van 1 tot 5",
          				"answers"=> [
          					"0"=> "1",
          					"1"=> "2",
          					"2"=> "3",
          					"3"=> "4",
          					"4"=> "5"
          				]
          			],
          			"3"=> [
          				"question"=> "Ik ben zorgvuldig ge??nformeerd en regelmatig betrokken bij de klachtenprocedure.",
                  "type"=> "value",
          				"required"=> 1,
          				"tips"=> "Waardering van 1 tot 5",
          				"answers"=> [
          					"0"=> "1",
          					"1"=> "2",
          					"2"=> "3",
          					"3"=> "4",
          					"4"=> "5"
          				]
          			],
          			"4"=> [
          				"question"=> "Ik voel mij sterker na de afhandeling van mijn melding/klacht. ",
                  "type"=> "value",
          				"required"=> 1,
          				"tips"=> "Waardering van 1 tot 5",
          				"answers"=> [
          					"0"=> "1",
          					"1"=> "2",
          					"2"=> "3",
          					"3"=> "4",
          					"4"=> "5"
          				]
          			],
          			"5"=> [
          				"question"=> "Discriminatie melden heeft zin.",
                  "type"=> "value",
          				"required"=> 1,
          				"tips"=> "Waardering van 1 tot 5",
          				"answers"=> [
          					"0"=> "1",
          					"1"=> "2",
          					"2"=> "3",
          					"3"=> "4",
          					"4"=> "5"
          				]
          			],
                "6"=> [
          				"question"=> "Ik raad mensen die discriminatie ervaren aan contact te zoeken met Stichting iDb.",
                  "type"=> "value",
          				"required"=> 1,
          				"tips"=> "Waardering van 1 tot 5",
          				"answers"=> [
          					"0"=> "1",
          					"1"=> "2",
          					"2"=> "3",
          					"3"=> "4",
          					"4"=> "5"
          				]
          			],
                "7"=> [
          				"question"=> "Hoe tevreden bent u over de wijze waarop uw melding/klacht is behandeld?",
                  "type"=> "value",
          				"required"=> 1,
          				"tips"=> "Waardering van 1 tot 10",
          				"answers"=> [
          					"0"=> "1",
          					"1"=> "2",
          					"2"=> "3",
          					"3"=> "4",
          					"4"=> "5",
          					"5"=> "6",
          					"6"=> "7",
          					"7"=> "8",
          					"8"=> "9",
          					"9"=> "10"
          				]
          			],
                "8"=> [
          				"question"=> "Heeft u nog andere opmerkingen of suggesties?",
          				"type"=> "open",
          				"required"=> 0,
          				"tips"=> "Opmerkingen of suggesties",
          				"max"=> 100,
          				"answers"=> [
          					"0"=> "Tekst max 100 woorden",
          				]
          			],

                          			"9"=> [
                          				"question"=> "Mogen wij u benaderen met voor een gesprek waarin u persoonlijk uitgebreide feedback geeft?",
                          				"type"=> "polar",
                          				"required"=> 1,
                          				"tips"=> "This is a survey",
                          				"answers"=> [
                          					"0"=> "No",
                          					"1"=> "Yes"
                          				]
                          			]
          		];



          $setup = json_encode($json, true);

          $this->fields = [
                  'fields' =>
                  [
                  'id'=>'Id',
                  'title'=>'Title',
                  'subtitle'=>'Sub Title',
                  'desc'=>'Short desc',

                  'email_salut'=>'Salutation',
                  'email_regards'=>'Regard',
                  'email_text'=>'Email start',
                  'email_surveyintro'=>'Email survey intro',
                  'email_end'=>'Email end',

                  'intro_title'=>'Intro title',
                  'intro_text'=>'Intro text',
                  'intro_subtext'=>'Intro sub text',

                  'survey_title'=>'Survey title',
                  'survey_start'=>'Info text',
                  'survey_end'=>'Info below text',
                  'survey_disclaimtext1'=>'Disclaim text 1',
                  'survey_help'=>'Help text',
                  'survey_helplink'=>'Help link',

                  'survey_complete_title'=> 'Completed title',
                  'survey_complete_text'=> 'Closing text',

                  'survey_after'=>'Extra info',
                  'outro_text'=>'Outro text',

                  'survey_disclaimtext2'=>'Disclaim text 2',
                  'survey_disclaimlinktext'=>'Link text',
                  'survey_disclaimlink'=>'Disclaimer link',

                  'json'=>'Survey Data',
                  ],
                  1 =>
                  [
                  'id'=>'id',
                  'title'=>'Header Title',
                  'subtitle'=>'Sub Title',
                  'desc'=>'Short description text',

                  'email_salut'=>'Dear',
                  'email_regards'=>'Best regards',
                  'email_text'=>'This email is send as a follow up on our recent contact. We would like to ask you to help us validate and enhance our services. Would you be so kind to answer a few questions?',
                  'email_surveyintro'=>'Below is the first question. By answering you will be directed anonymously to our website with the complete survey. Thank you for your effort!',
                  'email_end'=>'Email Outro text (finnishing) below the survey section followed by the regards and sender person name',

                  'intro_title'=>'Intro title',
                  'intro_text'=>'Intro text before the survey section',
                  'intro_subtext'=>'Intro sub text',

                  'survey_title'=>'Survey Example 1 Title',
                  'survey_start'=>'Please share your thoughts about your experience with our services by answering the following questions.',
                  'survey_end'=>'Info text inside survey box with questions',
                  'survey_disclaimtext1'=>'Disclaimer text 1 the below the end text underneath the survey box',
                  'survey_help'=>'Overall usage notes and tips text for help section',
                  'survey_helplink'=>'https://..#surveyhelp',

                  'survey_complete_title'=> 'Survey Completed!',
                  'survey_complete_text'=> 'Thank you for taking this journey!',

                  'survey_after'=>'Info text below survey box with questions',
                  'outro_text'=>'Outro text (finnishing) below the survey section',

                  'survey_disclaimtext2'=>'Disclaim text 2 at the end of the page above the footer (contact) area',
                  'survey_disclaimlinktext'=>'Disclaimer',
                  'survey_disclaimlink'=>'#disclaimer',

                  'json'=>$setup,

                  ],
                ];
        }

        private function setDefaultData(){

          $this->defineFields();
          $arr = $this->fields;
          $this->datalist = $arr;
	        $this->source->dataToFile( $arr, $this->filename );

        }
    }

?>
