<?php

namespace SNFe;

use Web\Google\StaticMap;

class Actions extends Resource
{
        
    /**
     * The endpoint that will hit the API.
     *
     * @return string
     */
    public function endpoint()
    {
        return 'do';
    }
    
    public function all(array $params = [])
    {
        throw new \Exception($this->msg_NoAvaliable);
    
    }
    
    public function create(array $form_params = [])
    {
        throw new \Exception($this->msg_NoAvaliable);
    }
    
    public function retrieve($id = null)
    {
        throw new \Exception($this->msg_NoAvaliable);
    }
    
    public function update($id = null, array $form_params = [])
    {
        throw new \Exception($this->msg_NoAvaliable);
    }
    
    public function delete($id = null, array $form_params = [])
    {
        throw new \Exception($this->msg_NoAvaliable);
    }
    
    public function get($id = null, $additionalEndpoint = null,array $params = [])
    {
        throw new \Exception($this->msg_NoAvaliable);
    }
    
    public function post($id = null, $additionalEndpoint = null, array $form_params = [])
    {
        throw new \Exception($this->msg_NoAvaliable);
    }

    
    /**
     * Gera Token de usuario (Não o Token de Conta.
     *
     * @param string    $usuario                  usuario (email).     *
     * @param string    $senha                    senha do usuario     *
     
     * @return array[Status , token, message]
     * token = array(token_id,token_secret)
     */
    public function consultarDFeSefaz($id){
        if(!is_int($id)){
            throw new \Exception('Informe a id da empresa');
        }
        return parent::post(null,'consultarDFeSefaz',['empresas_id'=>$id]);
    }
    
    
    
   
    
    /**
     * Faz busca de DFE (Documento FIscal Eletronico) junto a Sefaz.
     *
     * @param int    $id                  id da Empresa a ser realizada a busca.     *
     
     * @return mixed
     */
    public function consultarStatusSefaz($id){
        if(!is_int($id)){
            throw new \Exception('Informe a id da empresa');
        }        
        return parent::post(null,'consultarDFeSefaz',['empresas_id'=>$id]);
    }
    
    /**
     * Faz a consulta do status da NF-e/NFC-e junto a SEFAZ.
     *
     * @param int    $id                 id da Nota a ser Consultada.     *
     *
     * @return string
     */    
    public function consultarStatusNFE($id){
        if(!is_int($id)){
            throw new \Exception('Informe a id da nota para consulta status');
        }
        return parent::post(null,'consultarStatusNFE',['id'=>$id]);
    }
    
    /**
     * Faz a manifestacao da NF-e junto a SEFAZ.
     *
     * @param int    $id                  id da Nota a ser manifestada.     *
     * @param string $notas_manifesto_id  id do manifesto 
     *                                    210200 – Confirmação da Operação
     *                                    210210 – Ciência da Operação
     *                                    210220 – Desconhecimento da Operação
     *                                    210240 – Operação não Realizada   
     * @param string $txtJustificativa    (15-255) justificativa do manifesto Obrigatória para o tipo 210240 – Operação não Realizada  
     * @return string
     */    
    public function manifestarNFE($id,$notas_manifesto_id,$txtJustificativa){
        if(!is_int($id)){
            throw new \Exception('Informe a id da nota para manifestar');
        }
        if(!in_array($notas_manifesto_id, ['210200','210210','210220','210240']) ){
            throw new \Exception('Informe o codigo do tipo de Evento - (210200,210210,210220,210240)');
        }
        if($notas_manifesto_id == '210240' && (strlen($txtJustificativa) < 15 ||  strlen($txtJustificativa) > 255)){
            throw new \Exception('É obrigatória uma justificativa com 15 até 255 caracteres!! Evento - 210240');
        }
        return parent::post(null,'manifestarNFE',['id'=>$id,'notas_manifesto_id'=>$notas_manifesto_id,'txtJustificativa'=>$txtJustificativa]);
    }
    
    
    /**
     * Upload de Documentos XML - Empresas (Emitente ou Destinatário Pertencente a Conta).
     *     
     * @param string $xml   Conteudo do Arquivo XML - Base64
     
     * @return string
     */
    public function uploadXML($xml){
        if(strlen($xml)==0){
            throw new \Exception('Informe o Conteudo do Arquivo - base64');
        }
        return parent::post(null,'uploadXML',['xml'=>$xml]);
    }
    
    
    public function downloadXMLPDF($id,$xml=true,$pdf=true){
        if(!is_int($id)){
            throw new \Exception('Informe a id da nota');
        }
        $data = array();
        $data['id'] = $id;
        $data['xml'] = '0';
        $data['pdf'] = '0';
        if($xml){
            $data['xml'] = '1';
        }
        if($pdf){
            $data['pdf'] = '1';
        }
        return parent::post(null,'downloadXMLPDF',$data);        
    }
    
    
    public function createInvoiceDownload($params=array(),$xml=true,$pdf=true,$empresas_id=null){        
        if(is_null($empresas_id)){
            throw new \Exception('Informe a empresa');
        }
        $data = $params;
        $data['empresas_id'] = $empresas_id;
        $data['xml'] = '0';
        $data['pdf'] = '0';
        if($xml){
            $data['xml'] = '1';
        }
        if($pdf){
            $data['pdf'] = '1';
        }        
        return parent::post(null,'invoiceDownload',$data);
    }
    
    public function createInvoiceDownloadAsync($params=array(),$xml=true,$pdf=true,$empresas_id=null){
        if(is_null($empresas_id)){
            throw new \Exception('Informe a empresa');
        }
        $data = $params;
        $data['empresas_id'] = $empresas_id;
        $data['xml'] = '0';
        $data['pdf'] = '0';
        if($xml){
            $data['xml'] = '1';
        }
        if($pdf){
            $data['pdf'] = '1';
        }
        return parent::post(null,'invoiceDownloadAsync',$data);
    }
    
    public function statusInvoiceDownloadAsync($chave){
        if(is_null($chave)){
            throw new \Exception('Informe a chave do processo');
        }
        $data = array();
        $data['chave'] = $chave;        
        
        return parent::post(null,'statusDownloadAsync',$data);
    }
    

    public function criarNota($data){
        return parent::post(null,'invoiceCreate',$data);
    }
    
    public function cancelarNota($data){
        return parent::post(null,'invoiceCancel',$data);
    }
    
    public function gerarCCe($data){
        return parent::post(null,'invoiceCCe',$data);
    }
    
    public function dashboard($data){
        return parent::post(null,'dashboard',$data);
    }
    
    
    public function waitForInvoiceDownloadAsync($chave,$maxSeconds = 300, $currentSecond = 0) {
            
                if($currentSecond>$maxSeconds){
                    throw new \Exception("Tempo de estpera acima do limite - " . $maxSeconds . ' segundos');
                }
                if ($currentSecond == 0) {            
                    $wait = 60;
                } else {
                    $wait = 30;
                }        
                
                sleep($wait);
                
                $taskInfo = $this->statusInvoiceDownloadAsync($chave);
                
                
                if ($taskInfo->retorno->status == "processing") {
                    //repeating attempt
                    return $this->waitForInvoiceDownloadAsync($chave,$maxSeconds, ($currentSecond+$wait));
                    
                }
                if ($taskInfo->retorno->status == "finish") {
                    return $taskInfo;           
                }            
            throw new \Exception("Erro desconhecido da api");
        
    }
    
    
    
    
}
