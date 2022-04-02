<?php

    namespace App\Utils;

    abstract class Tratament
    {

        public function comeRecursive( array $val, $key )
        {
            array_walk_recursive( $val, function( $value, $keyup ) use ( &$data, $key, &$keys_save ){
                $keys_save[] = $keyup;
                $data[$key][$keyup] = $value;
            });

            return $data;
        }

        public function findData( array $find_data, array $data )
        {
            foreach( $find_data as $find_key => $find_val ) {
                if( in_array($find_val, array_keys( $data )) ){
                    $data[$find_key] = $data[$find_val];
                    unset($data[$find_val]);
                }
            }
            return $data;
        }

        public function diffColumns( array $columns_data, array $data )
        {
            $values_diff_values = array_diff( array_values($columns_data), array_keys($data) );
            foreach ($values_diff_values as $diff_key => $diff_val) {
                $data[$diff_val] = null;
            }

            $values_diff_keys = array_diff( array_keys( $data ), array_values( $columns_data ));
            foreach ($values_diff_keys as $diff_key => $diff_val) {
                unset($data[$diff_val]);
            }

            return $data;
        }
    }
?>