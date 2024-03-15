<?php
// wp-json/wc/v3/products?per_page=".$per_page."&page=".$page

    // boucle sur le nombre de paginations trouvées
    $array_product_finaal = array();


    $cunsumer_key = env('CONSUMER_KEY_WC'); 
    $consumer_secret = env('CONSUMER_SECRET_WC');             
    $status = 'publish'; // Statut des produits à filtrer
    
    // $urls = "https://www.elyamaje.com/wp-json/wc/v3/products?consumer_key=$cunsumer_key&consumer_secret=$consumer_secret&page=$i&per_page=100";


    // recupérer des donnees orders de woocomerce depuis api
    
    $headers = array(
        
        'Authorization'=> 'Basic' .base64_encode($cunsumer_key.':'.$consumer_secret)
        );
        
    //
    $data_final = array();
    $curl = curl_init();
    $i = 1;

    do {
        $urls = "https://www.elyamaje.com/wp-json/wc/v3/products?consumer_key=$cunsumer_key&consumer_secret=$consumer_secret&status=$status&page=$i&per_page=100";
        curl_setopt($curl, CURLOPT_URL, $urls);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_USERPWD, "$cunsumer_key:$consumer_secret");
        $resp = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
        $data = json_decode($resp,true);

        $taille = count($data);

        if ($taille != 0) {
            array_push($data_final,$data);
        }
        $i++;

    } while ($taille == 100);

    curl_close($curl);
    
    return $data_final;
