<?php

namespace www\tools;

class Tools {
    private $response;
    private $remoteip;
    private $secret="6Ld32l4UAAAAAFkB6KtDbcw_uQI8f5F06IaTB_7s";

    public function recaptchaCheck($gcaptcha, $ip)
    {
        $this->response = htmlspecialchars($gcaptcha);
        $this->remoteip = $ip;

        // Url to send a post request to
        $api_url = "https://www.google.com/recaptcha/api/siteverify";


        $fields = array(
            'secret' => $this->secret,
            'response' => $this->response,
            'remoteip' => $this->remoteip
        );

        $fields_string = "";

        //url-ify the data for the POST
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $api_url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //execute post
        $result = curl_exec($ch);

        //close connection
        curl_close($ch);

        $decode = json_decode($result, true);
        return true ;
        if ($decode['success'] == true) {
            // yeah good to go !!
        }

        else {var_dump($result);
            throw new \Exception("You are a bot, aren't you !! ".$decode['success']);
        }
    }
    public function texte_decoupe( $texte, $longueur_max, $separateur ) {
        if( strlen($texte) >= $longueur_max ) {
            $texte = substr( $texte, 0, $longueur_max );
            $dernier_espace = strrpos( $texte, ' ' );
            $texte = substr( $texte, 0, $dernier_espace);
            echo   $texte . ' ' . $separateur;
        }


        else echo   $texte; }
}
