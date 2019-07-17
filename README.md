![alt text align:center](https://www.sbaum.com.br/assets/img/logo-sbaum.png "Sbaum-Tecnologia")

# SNFe - SDK PHP


## Descrição
Este pacote consiste em um SDK em PHP para a utilizacao do sistema SNFe através de api - REST.

# Requisitos
- PHP >=5.5.19;


# Instalação

Via Composer

```bash
composer require sbaum-tecnologia/snfe-php
```

## Licença
GNU GPLv3. Por favor, veja o [Arquivo de Licença](license.txt) para mais informações.

## Exemplo
```php
require __DIR__.'/../vendor/autoload.php';

// Coloca o Token SNFe  no environment do PHP.

putenv('SNFE_TOKEN=AAAA');
putenv('SNFE_TOKEN_SECRET=aBBBCC');


// Cria Objetos de Consulta/Servico
 

$ServiceEmpresas = new SNFe\Empresas();
$ServiceNotas = new SNFe\Notas();
$ServiceActions = new SNFe\Actions();


$empresaNova = [
    'razao_social'=>'Teste',
    'nome_fantasia'=>'Teste',
    'cnpj'=>'50.311.620/0001-10',
    'inscricao_municipal'=>'',
    'inscricao_estadual'=>'',
    'endereco'=>'',
    'numero'=>'',
    'complemento'=>'',
    'bairro'=>'',
    'cidade'=>'',
    'estado'=>'',
    'cep'=>'',
    'responsavel_nome'=>'',
    'responsavel_email'=>'',
    'responsavel_telefone'=>'',
];





try {
    $_retCreate = $ServiceEmpresas->create(['data'=>$empresaNova]);
} catch (Exception $e) {
       echo $e->getMessage();
       exit;
}



try {        
    
    $ret = $ServiceEmpresas->all(['order'=>'cnpj desc','limit'=>10,'page'=>1,'filtros'=>[['id','>','1']]]);
    
    foreach ($ret->obj as $emp_obj){
        /*
         * Busca a empresa pelo id
         */
        
        $_ret = $ServiceEmpresas->get($emp_obj->id);
        
        echo "CNPJ: " . $_ret->cnpj . "</br>";
        echo "ID: " . $_ret->id . "</br>";
        /*
         * busca as notas que pertence a empresa
         */
        
        /*
         * Para buscas pelo nsu - numero sequencial para cada emissor gerado pela Sefaz - formatar conforme exemplo
         */
        $value = 7200;
        $nsu = str_pad($value, 15, '0', STR_PAD_LEFT);        
        
        
        $retN = $ServiceNotas->all(['order'=>'dhEmi desc','limit'=>5,'page'=>1,'filtros'=>[['empresas_id','=',$_ret->id],['xml_arquivado','=',1]]]);
        
        foreach ($retN->obj as $notas){
                /*
                 * Busca a nota pelo id
                 * o atributo xml retorna em base64
                 */
                $_retN = $ServiceNotas->get($notas->id);
                echo "----</br>";
                echo "ID: " . $_retN->id . "</br>";
                echo "Numero: " . $_retN->numero . "</br>";
                echo "Emissao: " . $_retN->dhEmi . "</br>";
                echo "Emitente/Destinatario: " . $_retN->xNome . "</br>";               
                /*
                 * Consulta Status da NF-e - parametro id da nota
                 */
                $ret_Consulta = $ServiceActions->consultarStatusNFE((int)$notas->id) ;
                echo $ret_Consulta->status . "</br>";
                echo $ret_Consulta->message->description . "</br>";
                
                /*
                 * Faz a manifestação da NF-e - parametro id da nota, tipo de manifestação, jusitificativa
                 */
                $ret_Consulta =  $ServiceActions->manifestarNFE((int)$notas->id, '210210', '');                
                echo $ret_Consulta->status . "</br>";
                echo $ret_Consulta->message->description. "</br>";
                echo "----</br>";
                /*
                 * Faz download do xml e/ou pdf - parametro id da nota, xml (true/false), pdf (true/false)
                 */
                $ret_Consulta =  $ServiceActions->downloadXMLPDF((int)$notas->id, true,true);
                echo $ret_Consulta->status . "</br>";               
                echo $ret_Consulta->message->xml->download->filename . "</br>";
                echo $ret_Consulta->message->xml->download->download . "</br>";
                echo $ret_Consulta->message->pdf->download->filename . "</br>";
                echo $ret_Consulta->message->pdf->download->download . "</br>";
                echo "----</br>";
         }
    }
    
  
    
    echo '--Fim--';
} catch (Exception $e) {
    echo $e->getMessage();    
}
