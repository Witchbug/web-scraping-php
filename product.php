<?php
$html = file_get_contents('https://www.pickaboo.com/kaspersky-safe-kids-protection-1pc-and-3-mobile.html'); //get the html returned from the following url

$pokemon_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors

if (!empty($html)) { //if any html is actually returned

    $pokemon_doc->loadHTML($html);
    libxml_clear_errors(); //remove errors for yucky html

    $pokemon_xpath = new DOMXPath($pokemon_doc);


    $pokemon_list = array();

    $pokemon_and_type = $pokemon_xpath->query('//div[@class="product-view-detail"]');
//    $parent_image     = $pokemon_xpath->query('//div[@class="product-shop"]');

    if ($pokemon_and_type->length > 0) {

        //loop through all the pokemons
        foreach ($pokemon_and_type as $pat) {

            //get the name of the pokemon
            $title = $pokemon_xpath->query('//h1[@class="product-productname"]', $pat)->item(0)->nodeValue;
            $price = $pokemon_xpath->query('//span[@class="price"]', $pat)->item(0)->nodeValue;
            $image = $pokemon_xpath->query('//a[@class="magnify-zoom-gallery"]', $pat)->item(0)->getAttribute('data-magnify-zoom') .'<br />' . PHP_EOL;

            //store the data in the $pokemon_list array
            $pokemon_list[] = array('title' => $title, 'price' => $price, 'image' => $image);

        }
    }

    //output what we have
    echo "<pre>";
    print_r($pokemon_list);
    echo "</pre>";

}
?>