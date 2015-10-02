<!DOCTYPE html>
<!--
Создайте класс, описывающий квартиру в жилом доме. В качестве примеров полей используйте количество комнат,
площадь, этаж, количество жильцов, наличие балконов и их количество, тип отопления и т.д.
Реализуйте методы, которые:
- производят расчет коммунальных услуг в зависимости от количества жильцов или площади квартиры
    (каждая услуга отдельно);
- рассчитывает сумму месячного платежа за все коммунальные услуги за месяц;
- добавляет и удаляет жильцов
- выводит информацию о квартире.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php
setlocale (LC_ALL, "ru_RU.UTF-8");
 mb_internal_encoding('UTF-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Generator {

function getFlats() {
    $persons=  rand(1, 14);
    $space= rand(45, 250);
    return new Flat($space, $persons);
}
function getBuild(){
    $flats= rand(8, 192);
    $area= rand(20, 100);
    $floors= rand(2, 16);
    $porches= rand(2, 3);
    $build = new Build($flats, $area, $floors, $porches);
    for ($index = 0; $index < $flats; $index++) {
        $build->addFlats($this->getFlats());
    }
    return $build;
}
function getStreet(){
    static $a=0;
      $a++;
    $name = $a;
    $street = new Street($name);
    $numb = rand(10, 20);
    for ($index = 0; $index < $numb; $index++) {
        $street->addBuilds($this->getBuild());
    }
    return $street;
}
function getTown(){
    $name = 'ГородОк';
    $town = new Town($name, 33.5555, 67.9999);
    $numb = rand(10, 20);
    for ($index = 0; $index < $numb; $index++) {
        $town->addStreets($this->getStreet());
    }
    return $town;
}
}
?>
        <?php
            class Flat {
                var $space;
                var $person;
                var $avg_energy=250;
                var $tariff_rent=2.11;
                var $tariff_energy=0.3;
                var $tariff_water=40;
                var $tariff_heating=4;

                function __construct($space, $person) {
                    $this->space = $space;
                    $this->person = $person;
    }
    function rent(){
        $rent=$this->space * $this->tariff_rent;
        return $rent;
    }
    function energy(){
        $energy=$this->avg_energy * $this->tariff_energy;
        return $energy;
    }
    function water(){
        $water=$this->person * $this->tariff_water;
        return $water;
    }
    function heating(){
        $heating=$this->space * $this->tariff_heating;
        return $heating;
    }
    function bill(){
        $bill=$this::rent()+$this::energy()+$this::water()+$this::heating();
        return $bill;
    }
    function setPerson($person){
        $this->person = $person;
    }
            function toString(){
        $str= 'Площадь квартиры: '.$this->space.' метров.'.'<br>'
        .'Количество жильцов: '.$this->person.'<br>'
        .'Коммунальные услуги за месяц: '.$this->bill().' грн.'.'<br>';
        return $str;
    }
}
?>
<!-- Создайте класс, описывающий жилой многоэтажный дом, состоящий из квартир. 
Используйте класс квартиры из предыдущего задания. 
В качестве примеров полей используйте номер дома, количество этажей, количество подъездов, квартиры, 
площади прилегающей территории и т.д. Реализуйте методы, которые:
- рассчитывает размер коммунальных платежей со всех квартир в этом доме;
- рассчитывает объем потребляемого электричества для освещения подъездов в зависимости от количества 
подъездов и этажей;
- рассчитывает размер налога на землю в зависимости от размера терртории, отведенной для дома;
- выводит информацию о доме.
Примечание.
Квартиры в одном доме удобнее всего хранить в массиве переменных.
-----------------------------------------------------------------
Создайте класс, описывающий улицу в населенном пункте. Используйте класс дом из предыдущего задания.
В качестве примеров полей используйте название улицы, ее протяженность, координаты начала и конца, дома и т.д.
Реализуйте методы, которые:
- рассчитывает количество дворников, которое необходимо для уборки прилегающих территорий всех домов по улице
в зависимости от площади этих территорий;
- рассчитывает объем коммунальных платежей, которые будут получены со всех домов;
- выводит информацию об улице. 
-->
<?php
$electr_vol=15;
$tax=4;
?>
 <?php

class Build {
            var $flats;
            var $area;
            var $floors;
            var $porches;
            var $arr_flats=array();

            function __construct($flats, $area, $floors, $porches){
                $this->flats = $flats;
                $this->area = $area;
                $this->floors = $floors;
                $this->porches = $porches;
            }
            function addFlats($flat){
                array_push($this->arr_flats,$flat);
            }
            function utilities(){
                $utilities=0;
                foreach ($this->arr_flats as $value){
                    $utilities+=$value->bill();
                }
                return $utilities;
            }
            function electr_vol(){
                global $electr_vol;
                return $electr_vol * $this->floors * $this->porches;
            }
            function tax(){
                global $tax;
                return $tax * $this->area;
            }
            function toString(){
        $str= 'Количество квартир: '.$this->flats.'<br>'
        .'Количество этажей: '.$this->floors.'<br>'
        . 'Количество подъездов: '.$this->porches.'<br>'
        . 'Электричество для освещения подъездов: '.$this->electr_vol().' кВт.'.'<br>'
        . 'Земельный налог: '.$this->tax().'<br>';
        return $str;
    }
}

class Street {
    var $name;
    var $arr_builds=array();
    function __construct($name) {
        $this->name=$name;    
    }
    function addBuilds($build){
        array_push($this->arr_builds,$build);
    }
    function yardman(){
                foreach ($this->arr_builds as $value){
                    $yardmans+=$value->area/300;
                }
                return ceil($yardmans);
            }
            function util_vol(){
                $utilit=0;
                foreach ($this->arr_builds as $value){
                    $utilit+=$value->utilities();
                }
                return $utilit;
            }
            function toString(){
        $str= 'Название улицы: '.$this->name.'<br>'
        . 'Количество домов: '.count($this->arr_builds).'<br>'
        . 'Коммунальные услуги за месяц: '.$this->util_vol().' грн.'.'<br>';
        return $str;
    }
}
class Town {
    var $town;
    var $coord_len;
    var $coord_wid;
    var $arr_streets=array();
    function __construct($town, $coord_len, $coord_wid) {
        $this->town = $town;
        $this->coord_len = $coord_len;
        $this->coord_wid = $coord_wid;
    }
    function addStreets($street){
        array_push($this->arr_streets,$street);
    }
    function population(){
        $population=0;
        foreach ($this->arr_streets as $each_street){
            foreach ($each_street->arr_builds as $each_build){
                foreach ($each_build->arr_flats as $each_flat){
                    $population+=$each_flat->person;
                }
            }
    }
                return $population;
    }
    function budget(){
        $budget=0;
        foreach ($this->arr_streets as $street){
            foreach ($street->arr_builds as $house){
                    $budget+=$house->tax();
            }
        }
                return $budget;
    }
    function toString(){
        $str= 'Название города: '.$this->town.'<br>'
        .'Количество улиц: '.count($this->arr_streets).'<br>'
        .'Бюджет населенного пункта: '.$this->budget().' грн.'.'<br>'
        .'Количество населения: '.$this->population().' человек'.'<br>';
        return $str;
    }
}
?>
<!-- Создайте класс, описывающий населенный пункт. В качестве примеров полей используйте название населенного пункта,
год основания, географические координаты и т.д. Реализуйте методы, которые:
- рассчитывает бюджет населенного пункта в зависимости от размера налога на землю, полученного со всех домов;
- рассчитывает количество населения, проживающего в населенном пункте;
- выводит информацию о населенном пункте.
-----------------------------------------
Создайте тестовую программу для проверки работоспособности вышеуказанных классов. -->
<?php
$a = new Generator();
$b = $a->getTown();
echo iconv('UTF-8', 'windows-1251', $b->toString());
foreach ($b->arr_streets as $each_street){
    echo iconv('UTF-8', 'windows-1251', $each_street->toString());
            foreach ($each_street->arr_builds as $each_build){
                echo iconv('UTF-8', 'windows-1251', $each_build->toString());
                foreach ($each_build->arr_flats as $each_flat){
                    echo iconv('UTF-8', 'windows-1251', $each_flat->toString());
                }
            }
}
?>
    </body>
</html>
