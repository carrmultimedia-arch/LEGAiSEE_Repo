<?php

function archive_search(string $query,int $limit=500): array
{
    $query=strtolower(trim($query));

    if ($query === '') {
    return [];
}

    $dir=__DIR__.'/../normalized/';
    $metaFile=$dir.'index_meta.json';

    if(!file_exists($metaFile))
        return [];

    $meta=json_decode(file_get_contents($metaFile),true) ?: [];

    $results=[];

    foreach($meta as $key=>$m){

        $file=$dir.$key;

        if(!file_exists($file))
            continue;

        $text=file_get_contents($file);

        $haystack=strtolower(
            ($m['file']??'').' '.
            ($m['client']??'').' '.
            $text
        );

        if($query!='' && strpos($haystack,$query)===false)
            continue;

        $score=0;

        $score+=substr_count($haystack,$query)*100;

        similar_text($query,$haystack,$pct);

        $score+=$pct;

        $m['key']=$key;
        $m['text']=$text;
        $m['score']=$score;

        $results[]=$m;
    }

    usort($results,function($a,$b){
        return $b['score']<=>$a['score'];
    });

    return array_slice($results,0,$limit);
}