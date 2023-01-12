<?php

namespace App\Service;

class Fivegear
{
public function get($title){
    $url='https://xn--80aaaoea1ebkq6dxec.xn--p1ai/manufacturers/' . $title;

    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result=curl_exec($ch);


    $dom= new \DOMDocument();
    libxml_use_internal_errors(true);
    $dom->loadHTML($result);
    libxml_use_internal_errors(false);
    $xpath= new \DOMXPath($dom);
    $response=[];
    $node=$xpath->query('//*[@id="manufacturer-info-page"]/div/article/div[1]/h1', $dom)->item(0);
    if ($node == null) {
        abort(404);
    }
    $response['brand']=$node->textContent;
    $node=$xpath->query('//*[@id="manufacturer-info-page"]/div/article/div[3]/p', $dom)->item(0);
    $response['description']=$node->textContent;
    preg_match_all('/<img.*itemprop="logo".*src="(.+)".*>/U', $result, $img);
    $response['brand_logo']='https://xn--80aaaoea1ebkq6dxec.xn--p1ai' . $img[1][0];
    preg_match_all('/<img.*itemprop="image".*src="(.+)".*>/U', $result, $img);
    $response['brand_sample']='https://xn--80aaaoea1ebkq6dxec.xn--p1ai' . $img[1][0];
    $node = $xpath->query('//*[@id="manufacturer-info-page"]/div/article/div[4]/div/section/div', $dom);
    $count = $node->count();
    for($i=1; $i<=$count; $i++) {
        $node = $xpath->query('//*[@id="manufacturer-info-page"]/div/article/div[4]/div/section/div['.$i.']/div[1]', $dom)->item(0);
        $key = $node->textContent;
        if($key=='Ссылки на официальные сайты:'){
            preg_match_all('/<a rel="nofollow".*href="(.+)".*>/U', $result, $href);
            $response['info'][$key]=$href[1][0];
        }
        elseif($key=='Ссылки на каталоги:'){
            preg_match_all('/<a rel="nofollow".*href="(.+)".*>/U', $result, $href);
            for($j=1; $j<=20; $j++) {
                if(array_key_exists($j, $href[1])){
                $response['info'][$key][$j] = $href[1][$j];
                }
                else{
                    $j=21;
                }
            }
        }
        else {
            $node1 = $xpath->query('//*[@id="manufacturer-info-page"]/div/article/div[4]/div/section/div[' . $i . ']/div[2]', $dom)->item(0);
            $response['info'][$key] = $node1->textContent;
        }
    }

    return $response;
}
}
