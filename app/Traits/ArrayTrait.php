<?php

trait ArrayTrait
{

    public function arrayIntersectInKeys($assocArray, $keysArray)
    {
        $result = [];
        foreach ($keysArray as $key) {
            if (!empty($assocArray[$key])) {
                $result[$key] = $assocArray[$key];
            }
        }

        return $result;
    }

    public function removeItemByValue($value, $arr)
    {
        $index = array_search($value, $arr);
        if ($index !== false) {
            unset($arr[$index]);

            return array_values($arr);
        } else {
            return $arr;
        }
    }

    public function removeItemByKey($keys, $arr)
    {
        if (!is_array($keys)) {
            $keys = explode(',', $keys);
        }
        $kArr = array();
        foreach ($keys as $key) {
            $kArr[$key] = "";
        }

        return array_diff_key($arr, $kArr);
    }

    public function mergeNumeric($arr1, $arr2)
    {
        $newInArr2 = array_diff($arr2, $arr1);

        return array_merge($arr1, $newInArr2);
    }

    public function mergeAssociative($arr1, $arr2)
    {
        if (!is_array($arr1)) {
            $arr1 = [];
        }
        if (!is_array($arr2)) {
            $arr2 = [];
        }

        $keys1 = array_keys($arr1);
        $keys2 = array_keys($arr2);
        $keys = array_merge($keys1, $keys2);
        $vals1 = array_values($arr1);
        $vals2 = array_values($arr2);
        $vals = array_merge($vals1, $vals2);
        $ret = [];

        foreach ($keys as $key) {
            list(, $val) = each($vals);
            $ret[$key] = $val;
        }

        return $ret;
    }

    public function getArrayKey($arr, $needle)
    {
        return array_search($needle, $arr);
    }

    public function shuffle($arr, $amount = false)
    {
        $keys = array_keys($arr);
        shuffle($keys);
        $res = array();
        $i = 0;
        foreach ($keys as $key) {
            $i++;
            $res[] = $arr[$key];
            if ($amount && $amount == $i) {
                break;
            }
        }

        return $res;
    }

    function array_msort($multiArray, $col)
    {
        $tmp = array();
        foreach ($multiArray as &$ma) {
            $tmp[] = &$ma[$col];
        }
        array_multisort($tmp, $multiArray);

        return $multiArray;
    }

    private function _trimItem(&$item)
    {
        $item = trim($item);
    }

    public function trimArray($arr)
    {
        array_walk($arr, array($this, '_trimItem'));

        return $arr;
    }

    public function removeEmptyItems($arr)
    {
        return array_filter($arr, function ($item) {
            return !empty($item) && trim($item) != '';
        });
    }

}