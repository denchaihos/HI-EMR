<?php
$accident_data=array(
    "ptname"=>"35",
    "visit_date"=>"37",
    "visit_time"=>"43",
    "accident_date"=>"37",
    "accident_time"=>"43",
    "accident_type"=>"43",
    "place"=>"43",
    "visit_type"=>"43",
    "pt_accident_type"=>"43",
    "vehicle_type"=>"43",
    "alcohol"=>"43",
    "nacrotic"=>"43",
    "belt"=>"43",
    "helmet"=>"43",
    "airway"=>"43",
    "stopbleed"=>"43",
    "splint"=>"43",
    "fluid"=>"43",
    "urgency"=>"43",
    "coma_eye"=>"43",
    "coma_speak"=>"43",
    "coma_move"=>"43",
    "note"=>"43"
);
$trauma=array(
    'trauma' =>  array(
        'label'=>'t',
        'values'=>20
    ) ,
    'ntrauma' =>  array(
        'label'=>'n',
        'values'=>30
    ) ,
);
$case=array(
    'acceident'=>'A',
    'emergency'=>'E',
    'non_e_a'=>'',
);
/*
foreach($trauma as $key=>$value)
{
    echo $key.":".$value;
    echo '<br>';
}*/
foreach($trauma as $data)
{
    echo $data['trauma'];
    echo '<br>';
}
print_r($trauma);

echo '<br>';
echo $trauma["trauma"]["label"];
echo '<br>';
echo $trauma["ntrauma"]["label"];


