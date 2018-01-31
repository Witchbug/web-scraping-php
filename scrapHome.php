<?php
$html = file_get_contents('https://www.pickaboo.com/'); //get the html returned from the following url

$pokemon_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if (!empty($html)) { //if any html is actually returned

    $pokemon_doc->loadHTML($html);
    libxml_clear_errors(); //remove errors for yucky html

    $pokemon_xpath = new DOMXPath($pokemon_doc);

    $pokemon_list = array();
    $pokemon_and_type = $pokemon_xpath->query('//div[@class="syn-hot-deals"]');

    if ($pokemon_and_type->length > 0) {

        //loop through all the pokemons
        for($count=0; $count<5; $count++){
        foreach ($pokemon_and_type as $pat) {

                //get the name of the pokemon
                $title = $pokemon_xpath->query('//div[@class="syn-product-name"]', $pat)->item($count)->nodeValue;
                $price = $pokemon_xpath->query('//div[@class="syn-product-price"]', $pat)->item($count)->nodeValue;
                $url = $pokemon_xpath->query('//div[@class="syn-product-image"]//a', $pat)->item($count)->getAttribute('href');
                $image = $pokemon_xpath->query('//div[@class="syn-product-image"]//a//img', $pat)->item($count)->getAttribute('data-original');

                //store the data in the $pokemon_list array
                $pokemon_list[] = array('title' => $title, 'price' => $price, 'url' => $url, 'image' => $image);
            }
        }
    }
    //output what we have
    echo "<pre>";
    print_r($pokemon_list);
    echo "</pre>";
}
?>