<!-- 
Given a file, phones.txt, containing a list of phone numbers, one per line:
1. Write a class to read the list
2. Output a well formatted HTML page listing:
    a. Each phone number properly formatted
    b. Whether each phone number is a valid phone number or why it is not
    c. Whether each phone number originates in North Carolina. -->

 <html>
 <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
 </head>   
<?php
    class readPhones{
        protected $NCcodes = ['252', '910', '336', '743', '828', '919', '984', '704', '980'];
        protected $outPhones = [];
        
        public function readPhoneFile(){
            $rp = fopen('phones.txt', 'r');
            while (!feof($rp)){
                $phoneNumber = fgets($rp);
                //remove any new line character
                $phoneNumber = preg_replace('/[^0-9]/s', '', $phoneNumber);
                $message = '';
                $formattedNumber = '';
                
                //check if valid number
                if(ctype_digit($phoneNumber)){
                    // account for +1 in phone number
                    if(strlen($phoneNumber) == 11){
                        $phoneNumber = preg_replace('/^1/', '', $phoneNumber);
                    }
                    //check if valid phone number(valid = 10 digits)
                    if(strlen($phoneNumber) == 10){
                        $formattedNumber = "(". substr($phoneNumber, 0, 3) .') '.
                                           substr($phoneNumber, 3, 3) .'-'.
                                           substr($phoneNumber, 6);
                        if(in_array(substr($phoneNumber, 0, 3), $this->NCcodes)){
                            $message = "This is an NC area code.";
                        }
                        array_push($this->outPhones, ['originalNumber' => $phoneNumber, 
                            'formatNumber' => $formattedNumber, 
                            'message' => $message
                            ]);
                    }
                    else {
                        $message = "This is not a valid phone number.";

                        array_push($this->outPhones, ['originalNumber' => $phoneNumber, 
                            'formatNumber' => "", 
                            'message' => $message
                            ]);
                    }
                }
                else {
                    $message = "This is not a number.";
                    array_push($this->outPhones, ['originalNumber' => $phoneNumber, 
                            'formatNumber' => "", 
                            'message' => $message
                            ]);
                }
            }
            fclose($rp);
        }
        
        public function outputPhones(){
            //create html output table
            echo "<table class='table'>";
                echo "<h2>Phone Number List </h2>";
                echo "<tr>";
                    echo "<td> Original Number </td>";
                    echo "<td> Formatted Number </td>";
                    echo "<td> Message </td>";
                echo "</tr>";
                //loop through saved output line
                for($i = 0; $i < count($this->outPhones); $i++){
                    echo "<tr>";
                        echo "<td>" . $this->outPhones[$i]['originalNumber'] ."</td>";
                        echo "<td>" . $this->outPhones[$i]['formatNumber'] ."</td>";
                        echo "<td>" . $this->outPhones[$i]['message'] ."</td>";
                    echo "</tr>";
                }
            echo "</table>";
        }
    }
    
    // test to make sure class works
    
    $test = new readPhones();
    $test->readPhoneFile();
    $test->outputPhones();
?>