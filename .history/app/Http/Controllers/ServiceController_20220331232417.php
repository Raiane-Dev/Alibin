<?php
    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\DB;
    use App\Http\Utils\Tratament;

    class ServiceController extends Tratament
    {
        public function call(
            array $values,
            array | string $ret_data,
            array $find_data = null,
            bool $automatic_key = true,
            bool $recursion = false
        ) {
            
            /**
             * Caso seja uma string, significa que o argumento passado é o nome de uma tabela do banco de dados
             * Caso seja um array, significa que os parâmetros serão passados na mão.
             */

            if( is_string($ret_data) ){
                $columns = DB::getSchemaBuilder()->getColumnListing($ret_data);
            }
            else if( is_array($ret_data) ){
                $columns = array_filter($ret_data);
            }

            for( $index = 0; $index < count($columns); $index++ ){
                $name_columns[] = $columns[$index]["Field"];
            }

            $values = array_filter($values);
            foreach( $values as $key => $val ){



            }
            unset($values);
        }
    }

?>