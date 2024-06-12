<?php

namespace App\Http\Services;

class AprioriService 
{
    function frekuensiItem($data)
        {
            $arr = [];
            for ($i = 0; $i < count($data); $i++) {
                $jum = array_count_values($data[$i]);
                foreach ($jum as $key => $v) {
                    if (array_key_exists($key, $arr)) {
                        $arr[$key] += 1;
                    } else {
                        $arr[$key] = 1;
                    }
                }
            }
            return $arr;
        }


        function eliminasiItem($data, $minSupport)
        {
            $arr = [];
            foreach ($data as $key => $v) {
                if ($v >= $minSupport) {
                    $arr[$key] = $v;
                }
            }
            return $arr;
        }


        function pasanganItem($data_filter)
        {
            $n = 0;
            $arr = [];
            foreach ($data_filter as $key1 => $v1) {
                $m = 1;
                foreach ($data_filter as $key2 => $v2) {
                    $str = explode("_", $key2);
                    for ($i = 0; $i < count($str); $i++) {

                        if (!strstr($key1, $str[$i])) {
                            if ($m > $n + 1 && count($data_filter) > $n + 1) {
                                $arr[$key1 . "_" . $str[$i]] = 0;
                            }
                        }
                    }
                    $m++;
                }
                $n++;
            }
            return $arr;
        }

        function frekuensiPasanganItem($data_pasangan, $data)
        {
            $arr = $data_pasangan;
            $ky = "";
            $kali = 0;
            foreach ($data_pasangan as $key1 => $k) {
                for ($i = 0; $i < count($data); $i++) {
                    $kk = explode("_", $key1);
                    $jm = 0;
                    for ($k = 0; $k < count($kk); $k++) {

                        for ($j = 0; $j < count($data[$i]); $j++) {
                            if ($data[$i][$j] == $kk[$k]) {
                                $jm += 1;
                                break;
                            }
                        }
                    }
                    if ($jm > count($kk) - 1) {
                        $arr[$key1] += 1;
                    }
                }
            }
            return $arr;
        }
}