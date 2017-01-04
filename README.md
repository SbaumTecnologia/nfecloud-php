![alt text align:center](https://www.sbaum.com.br/images/logo-mini.png "Sbaum")

# NFeCloud - SDK PHP


## Descrição
Este pacote consiste em um SDK em PHP para a utilizacao do sistema NFeCLoud através de api - REST.

# Requisitos
- PHP >=5.5.19;


# Instalação

Via Composer

```bash
composer require sbaum-tecnologia/nfecloud-php
```

## Licença
GNU GPLv3. Por favor, veja o [Arquivo de Licença](license.txt) para mais informações.

## Exemplo
```php
require __DIR__.'/../vendor/autoload.php';

// Coloca o Token NFECLOUD  no environment do PHP.

putenv('NFECLOUD_TOKEN=AAAA');
putenv('NFECLOUD_TOKEN_SECRET=aBBBCC');


// Cria Objetos de Consulta/Servico
 

$ServiceEmpresas = new NFeCloud\Empresas();
$ServiceNotas = new NFeCloud\Notas();
$ServiceActions = new NFeCloud\Actions();


// Obtem Todas as Empresas vinculadas a conta 
// 'order' => ordena pelo atributo especificadp [asc=>ascendente, desc=>descendente]
// 'limit' => qual o numero de elementos deve buscas (máximo 100)
// 'page' => qual a página ( para mostrar do elemento 201 ao 300 busque pela página 3)
// 'filtros' => array de condicões para pesquisa no formato: array('atributo',criteria('=','>=','<=','>','<','like,'IN'),'valor')
// 
//  retorno: array com ids encontrados
 //

try {        
    
    $ret = $ServiceEmpresas->all(['order'=>'cnpj desc','limit'=>10,'page'=>1,'filtros'=>[['id','=','107']]]);    
    foreach ($ret->ids as $id){
        
         // Busca a empresa pelo id         
        $_ret = $ServiceEmpresas->get($id);
        echo "CNPJ: " . $_ret->cnpj . "</br>";
        echo "ID: " . $_ret->id . "</br>";
        
        // busca as notas que pertence a empresa
        // Para buscas pelo nsu - numero sequencial para cada emissor gerado pela Sefaz - formatar conforme exemplo
        
        $value = 7200;
        $nsu = str_pad($value, 15, '0', STR_PAD_LEFT);        
        
        
        $retN = $ServiceNotas->all(['order'=>'dhEmi desc','limit'=>2,'page'=>1,'filtros'=>[['empresas_id','=',$_ret->id],['nsu','>=',$nsu],['xml_arquivado','=',1]]]);        
        foreach ($retN->ids as $id){
                
                // Busca a nota pelo id
                // o atributo xml retorna em base64
                $_retN = $ServiceNotas->get($id);
                echo "----</br>";
                echo "ID: " . $_retN->id . "</br>";
                echo "Numero: " . $_retN->numero . "</br>";
                echo "Emissao: " . $_retN->dhEmi . "</br>";
                echo "Emitente/Destinatario: " . $_retN->xNome . "</br>";
                //echo "xml: " . base64_decode($_retN->xml) . "</br>";
                
                // Consulta Status da NF-e - parametro id da nota
                 
                $ret_Consulta = $ServiceActions->consultarStatusNFE((int)$_retN->id) ;
                echo $ret_Consulta . "</br>";
                
                //Faz a manifestação da NF-e - parametro id da nota, tipo de manifestação, jusitificativa
                
                $ret_Consulta =  $ServiceActions->manifestarNFE((int)$_retN->id, '210210', '');
                echo $ret_Consulta . "</br>";
                echo "----</br>";
                
                 //Faz download do xml e/ou pdf - parametro id da nota, xml (true/false), pdf (true/false)
                 
                $ret_Consulta =  $ServiceActions->downloadXMLPDF((int)$_retN->id, true,true);                
                print_r($ret_Consulta) . "</br>";
                echo "----</br>";
         }
    }
    
    
    // Consulta novos documentos (DFE) emitidas para a empresa
    //DFE - Resumos de Notas // XML - arquivos xml // Eventos - Eventos vinculados 
    
    $ret_Consulta =  $ServiceActions->consultarDFeSefaz((int)'107');
    print_r($ret_Consulta);
    
    //Upload de arquivos xml (NF-e/NFC-e/CT-e/NFS-e/Eventos)
         
    $conteudo = file_get_contents(__DIR__.'/41170107464573000115550010000060971776089318nfe.xml');
    $xml = base64_encode($conteudo);
    $ret_upl = $ServiceActions->uploadXML($xml);
    echo $ret_upl;
    echo '--Fim--';
} catch (Exception $e) {
    echo $e->getMessage();    
}