<?php
    namespace App\Http\Controllers;

    use Illuminate\Support\Facades\Schema;
    use App\Utils\Tratament;

    class ServiceController extends Tratament
    {
        public function call(
            array $values,
            string $position = null,
            array | string $ret_data,
            array $find_data = null,
            bool $recursion = false
        ) {
            
            /**
             * Caso seja uma string, significa que o argumento passado é o nome de
             * uma tabela do banco de dados.
             * Caso seja um array, significa que os parâmetros serão passados na mão.
             */
            if( is_string($ret_data) ){
                $columns = Schema::getColumnListing($ret_data);
            }
            else if( is_array($ret_data) ){
                $columns = $ret_data;
            }

            /**
             * Caminha pelo array com o nome das tabelas, ou os argumentos passados 
             * no array.
             */
            for( $index = 0; $index < count($columns); $index++ ){
                $name_columns[] = $columns[$index];
            }

            /**
             * Caso algum array venha nulo, o foreach para imediatamente. Com array
             * filter garantimos a integridade dos dados.
             */

            if($position !== null) $values = $values[$position];

            foreach( $values as $key => $val ){

                /**
                 * Se o array for multidimencional e eu precisar dos dados
                 * que estão dentro desse array filho, vou precisar puxá-los para o
                 * array pai, e assim conseguir acessar suas propriedades sem problemas.
                 */
                if($recursion){
                    $newVal = $this->comeRecursive( $val, $key );
                    $newVal = $newVal[$key];
                } else {
                    $newVal = $val;
                }

                /**
                 * Caso o nome das colunas da tabela do banco de dados tenha o nome diferente
                 * das chaves que a api retorna, ele encontra e atribui a uma nova chave.
                 * (essa nova chave seria o nome da coluna da tabela).
                 */
                if($find_data !== null) $newVal = $this->findData( $find_data, $newVal );

                /**
                 * Caso alguma coluna não seja encontrada na api, atríbuimos um valor nulo
                 * e/ou excluímos essa chave.
                 */

                $newVal = $this->diffColumns( $name_columns, $newVal );

                $f = fopen("php://stdout", "w");
                fwrite($f, json_encode($newVal)."\n");
                // fclose($f);
            }

            /**
             * Garantindo a limpeza da memória
             */
            unset($values);
        }
    }

?>