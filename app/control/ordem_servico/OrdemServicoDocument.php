<?php

class OrdemServicoDocument extends TPage
{
    private static $database = 'moraisjr_eti';
    private static $activeRecord = 'OrdemServico';
    private static $primaryKey = 'id';
    private static $htmlFile = 'app/documents/OrdemServicoDocumentTemplate.html';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {

    }

    public static function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $class = self::$activeRecord;
            $object = new $class($param['key']);

            $html = new AdiantiHTMLDocumentParser(self::$htmlFile);
            $html->setMaster($object);

            $criteria_OrdemServicoAtendimento_ordem_servico_id = new TCriteria();
            $criteria_OrdemServicoAtendimento_ordem_servico_id->add(new TFilter('ordem_servico_id', '=', $param['key']));

            $objectsOrdemServicoAtendimento_ordem_servico_id = OrdemServicoAtendimento::getObjects($criteria_OrdemServicoAtendimento_ordem_servico_id);
            $html->setDetail('OrdemServicoAtendimento.ordem_servico_id', $objectsOrdemServicoAtendimento_ordem_servico_id);

            $pageSize = 'A4';
            $document = 'tmp/'.uniqid().'.pdf'; 

            $html->process();

            $html->saveAsPDF($document, $pageSize, 'portrait');

            TTransaction::close();

            if(empty($param['returnFile']))
            {
                parent::openFile($document);

                new TMessage('info', _t('Document successfully generated'));    
            }
            else
            {
                return $document;
            }
        } 
        catch (Exception $e) 
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }

}

